<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return view('cart.index', [
                'cartItems' => [],
                'subtotalWithoutTax' => 0,
                'discount' => 0,
                'total' => 0,
                'coupon' => null
            ]);
        }

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $subtotalWithoutTax = 0;
        $cartItems = [];
        foreach ($cart as $id => $item) {
            $product = $products[$id] ?? null;
            if (!$product) continue;

            $quantity = (int) $item['quantity'];
            $priceWithoutTax = (float) $product->price;
            $totalWithoutTax = $priceWithoutTax * $quantity;
            $subtotalWithoutTax += $totalWithoutTax;
            $taxRate = $product->tax_rate ?? 20;

            $cartItems[$id] = [
                'id'                     => $id,
                'name'                   => $product->name,
                'slug'                   => $product->slug,
                'price_without_tax'      => $priceWithoutTax,
                'price_with_tax'         => $priceWithoutTax * (1 + $taxRate / 100),
                'quantity'               => $quantity,
                'total_without_tax'      => $totalWithoutTax,
                'tax_rate'               => $taxRate,
            ];
        }

        // Расчёт скидки
        $discount = 0;
        $coupon = session()->get('coupon');
        if ($coupon) {
            if (!$coupon->isValid()) {
                session()->forget('coupon');
                $coupon = null;
            } else {
                if ($coupon->discount_type === 'percentage') {
                    $discount = $subtotalWithoutTax * ($coupon->discount_value / 100);
                } else {
                    $discount = $coupon->discount_value;
                }
                $discount = min($discount, $subtotalWithoutTax);
            }
        }

        $totalAfterDiscountWithoutTax = $subtotalWithoutTax - $discount;
        $totalVat = 0;
        $total = 0;
        $discountFactor = $subtotalWithoutTax > 0 ? $totalAfterDiscountWithoutTax / $subtotalWithoutTax : 1;

        foreach ($cartItems as &$item) {
            $item['total_discounted_without_tax'] = $item['total_without_tax'] * $discountFactor;
            $item['tax_amount'] = $item['total_discounted_without_tax'] * $item['tax_rate'] / 100;
            $item['total_with_tax'] = $item['total_discounted_without_tax'] + $item['tax_amount'];
            $totalVat += $item['tax_amount'];
            $total += $item['total_with_tax'];
        }

        return view('cart.index', compact(
            'cartItems',
            'subtotalWithoutTax',
            'discount',
            'total',
            'coupon',
            'totalAfterDiscountWithoutTax',
            'totalVat'
        ));
    }

    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        $quantity = $request->input('quantity', 1);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'name'     => $product->name,
                'slug'     => $product->slug,
                'price'    => $product->price,        // цена без НДС
                'image'    => $product->image,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Товар добавлен в корзину');
    }

    public function update(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }
        return redirect()->route('cart.index')->with('success', 'Корзина обновлена');
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);
        unset($cart[$product->id]);
        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Товар удалён');
    }

    private function calculateTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['coupon' => 'required|string']);
        $code = $request->coupon;
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon || !$coupon->isValid()) {
            return redirect()->route('cart.index')->with('error', 'Промокод недействителен или истёк');
        }

        session(['coupon' => $coupon]);
        return redirect()->route('cart.index')->with('success', 'Промокод применён!');
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return redirect()->route('cart.index')->with('success', 'Промокод удалён');
    }
}