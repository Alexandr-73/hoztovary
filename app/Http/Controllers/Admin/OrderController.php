<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    /**
     * Список заказов
     */
    public function index()
    {
        $orders = Order::with('items.product')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Детальный просмотр заказа
     */
    public function show(Order $order)
    {
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Обновление статуса заказа
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Статус заказа обновлён');
    }

//     public function checkout()
// {
//     $cart = session()->get('cart', []);
//     if (empty($cart)) {
//         return redirect()->route('cart.index')->with('error', 'Корзина пуста');
//     }

//     // Считаем сумму без НДС
//     $subtotal = 0;
//     foreach ($cart as $item) {
//         $subtotal += $item['price'] * $item['quantity'];
//     }

//     $discount = 0;
//     $coupon = session()->get('coupon');
//     if ($coupon) {
//         if (!$coupon->isValid()) {
//             session()->forget('coupon');
//             $coupon = null;
//         } else {
//             if ($coupon->discount_type === 'percentage') {
//                 $discount = $subtotal * ($coupon->discount_value / 100);
//             } else {
//                 $discount = $coupon->discount_value;
//             }
//             $discount = min($discount, $subtotal);
//         }
//     }

//     // Рассчитываем НДС и итоговую сумму с НДС
//     $totalVat = $this->calculateVat($cart, $discount);
//     $totalWithVat = $subtotal - $discount + $totalVat;

//     // Формируем массив для отображения в таблице заказа с ценами, включающими НДС
//     $cartWithVat = [];
//     foreach ($cart as $id => $item) {
//         $product = Product::find($id);
//         if ($product) {
//             $priceWithVat = $product->price * (1 + ($product->tax_rate ?? 20) / 100);
//         } else {
//             $priceWithVat = $item['price'];
//         }
//         $cartWithVat[$id] = [
//             'name'     => $item['name'],
//             'quantity' => $item['quantity'],
//             'price'    => $priceWithVat,
//         ];
//     }

//     // Для отладки – раскомментируйте, чтобы увидеть значение
//     // dd($totalWithVat, $subtotal, $discount, $totalVat);

//     return view('order.checkout', compact('cartWithVat', 'subtotal', 'discount', 'totalWithVat'));
// }
// /**
//  * Рассчитывает сумму НДС на основе корзины и применённой скидки.
//  * Скидка применяется к сумме без НДС, НДС начисляется на сумму после скидки.
//  *
//  * @param array $cart
//  * @param float $discount
//  * @return float
//  */
// private function calculateVat($cart, $discount)
// {
//     $productIds = array_keys($cart);
//     $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

//     $subtotalWithoutTax = 0;
//     $items = [];

//     foreach ($cart as $id => $item) {
//         $product = $products[$id] ?? null;
//         if (!$product) continue;

//         $priceWithoutTax = $product->price;
//         $quantity = $item['quantity'];
//         $totalWithoutTax = $priceWithoutTax * $quantity;
//         $subtotalWithoutTax += $totalWithoutTax;

//         $items[] = [
//             'price'    => $priceWithoutTax,
//             'quantity' => $quantity,
//             'tax_rate' => $product->tax_rate ?? 20,
//         ];
//     }

//     $discountFactor = $subtotalWithoutTax > 0 ? ($subtotalWithoutTax - $discount) / $subtotalWithoutTax : 1;
//     $totalVat = 0;

//     foreach ($items as $item) {
//         $discountedWithoutTax = $item['price'] * $item['quantity'] * $discountFactor;
//         $totalVat += $discountedWithoutTax * $item['tax_rate'] / 100;
//     }

//     return $totalVat;
// }

    /**
     * Если требуется редактирование заказа (например, изменение состава), 
     * можно добавить метод edit и update. Но обычно для заказов достаточно изменения статуса.
     */
    // public function edit(Order $order) { ... }
    // public function update(Request $request, Order $order) { ... }
}
