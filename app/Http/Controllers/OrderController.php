<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\KomtetService;
use App\Services\EvotorReceiptService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $discount = 0;
        $coupon = session()->get('coupon');
        if ($coupon) {
            if (!$coupon->isValid()) {
                session()->forget('coupon');
                $coupon = null;
            } else {
                if ($coupon->discount_type === 'percentage') {
                    $discount = $subtotal * ($coupon->discount_value / 100);
                } else {
                    $discount = $coupon->discount_value;
                }
                $discount = min($discount, $subtotal);
            }
        }

        $totalVat = $this->calculateVat($cart, $discount);
        $totalWithVat = $subtotal - $discount + $totalVat;

        $cartWithVat = [];
        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $priceWithVat = $product->price * (1 + ($product->tax_rate ?? 20) / 100);
            } else {
                $priceWithVat = $item['price'];
            }
            $cartWithVat[$id] = [
                'name'           => $item['name'],
                'quantity'       => $item['quantity'],
                'price_with_vat' => $priceWithVat,
            ];
        }

        $deliveryPrice = 0;

        return view('order.checkout', compact('cartWithVat', 'subtotal', 'discount', 'totalWithVat', 'deliveryPrice'));
       
    }

    // ... методы store, success, calculateTotal, calculateVat ...

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'payment_method' => 'required|in:cash,card,online',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        $subtotal = $this->calculateTotal($cart);
        $coupon = session()->get('coupon');
        $discount = 0;
        if ($coupon && $coupon->isValid()) {
            if ($coupon->discount_type === 'percentage') {
                $discount = $subtotal * ($coupon->discount_value / 100);
            } else {
                $discount = $coupon->discount_value;
            }
            $discount = min($discount, $subtotal);
        }

        // Расчёт НДС и итоговой суммы с НДС
        $totalVat = $this->calculateVat($cart, $discount);
        $total = $subtotal - $discount + $totalVat; // сумма к оплате (с НДС)
        // $deliveryDistance = $request->input('delivery_distance_km', 0);

        // $delivery_price = $delivery_distance_km * 50; // 50 ₽ за км
        // $order->delivery_price = $delivery_price;
        // $order->save();

        DB::beginTransaction();
        try {
            $deliveryDistance = $request->input('delivery_distance_km', 0);
            $deliveryPrice = $deliveryDistance * 50;
            $total = $subtotal - $discount + $totalVat + $deliveryPrice; // общая сумма с доставкой
        
            $order = Order::create([
                'customer_name'    => $request->name,
                'customer_email'   => $request->email,
                'customer_phone'   => $request->phone,
                'shipping_address' => $request->address,
                'payment_method'   => $request->payment_method,
                'subtotal'         => $subtotal,
                'discount'         => $discount,
                'total'            => $total,
                'status'           => 'pending',
                'delivery_distance_km' => $deliveryDistance,
                'delivery_price'       => $deliveryPrice,
            ]);
        
            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $id,
                    'product_name' => $item['name'],
                    'quantity'     => $item['quantity'],
                    'price'        => $item['price'],      // цена без НДС
                    'subtotal'     => $item['price'] * $item['quantity'],
                ]);
                Product::where('id', $id)->decrement('stock', $item['quantity']);
            }

            if ($coupon && $coupon->isValid()) {
                $coupon->increment('used_count');
                session()->forget('coupon');
            }

            session()->forget('cart');
            DB::commit();

            try {
                $evotorReceipt = new EvotorReceiptService();
                $evotorReceipt->createReceipt($order, $cart);
                $order->receipt_sent = true;
                $order->save();
            } catch (\Exception $e) {
                Log::error('Ошибка отправки чека в Эвотор: ' . $e->getMessage());
            }

            // // Отправка чека в Комтет
            // $receiptSent = false;
            // try {
            //     $komtet = new KomtetService();
            //     $komtet->createReceipt($order, $cart);
            //     $receiptSent = true;
            // } catch (\Exception $e) {
            //     Log::error('Ошибка отправки чека в Комтет: ' . $e->getMessage());
            // }

            // Обновляем заказ: поле receipt_sent
            $order->receipt_sent = $receiptSent;
            $order->save();

            return redirect()->route('order.success', $order)->with('success', 'Заказ оформлен!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ошибка: ' . $e->getMessage());
        }
    }

    public function success(Order $order)
    {
        return view('order.success', compact('order'));
    }

    /**
     * Рассчитывает сумму НДС на основе корзины и применённой скидки.
     * Скидка применяется к сумме без НДС, НДС начисляется на сумму после скидки.
     *
     * @param array $cart
     * @param float $discount
     * @return float
     */
    private function calculateVat($cart, $discount)
    {
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $subtotalWithoutTax = 0;
        $items = [];

        foreach ($cart as $id => $item) {
            $product = $products[$id] ?? null;
            if (!$product) continue;

            $priceWithoutTax = $product->price;
            $quantity = $item['quantity'];
            $totalWithoutTax = $priceWithoutTax * $quantity;
            $subtotalWithoutTax += $totalWithoutTax;

            $items[] = [
                'price'    => $priceWithoutTax,
                'quantity' => $quantity,
                'tax_rate' => $product->tax_rate ?? 20,
            ];
        }

        $discountFactor = $subtotalWithoutTax > 0 ? ($subtotalWithoutTax - $discount) / $subtotalWithoutTax : 1;
        $totalVat = 0;

        foreach ($items as $item) {
            $discountedWithoutTax = $item['price'] * $item['quantity'] * $discountFactor;
            $totalVat += $discountedWithoutTax * $item['tax_rate'] / 100;
        }

        return $totalVat;
    }

    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}