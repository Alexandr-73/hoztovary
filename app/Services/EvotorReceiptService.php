<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class EvotorReceiptService
{
    protected $token;

    public function __construct()
    {
        $this->token = config('services.evotor.api_key');
    }

    public function createReceipt($order, $cart)
    {
        $items = [];
        foreach ($cart as $item) {
            $items[] = [
                'name' => $item['name'],
                'price' => (int) ($item['price'] * 100),
                'quantity' => (int) $item['quantity'],
                'tax' => 'NO_VAT',
                'amount' => (int) ($item['price'] * $item['quantity'] * 100),
                'external_id' => (string) $item['id'], // или $item['sku'] – ID товара из вашей БД
                ];
        }

        $data = [
            'external_id' => (string) $order->id,
            'customer' => [
                'email' => $order->customer_email,
                'phone' => $order->customer_phone,
            ],
            'positions' => $items,
            'total' => (int) ($order->total * 100),
            'payment_type' => $order->payment_method === 'online' ? 'ELECTRON' : 'CASH',
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/vnd.evotor.v2+json',
        ])->post('https://api.evotor.ru/api/v2/receipts', $data);

        if (!$response->successful()) {
            throw new \Exception('Ошибка отправки чека в Эвотор: ' . $response->body());
        }

        return $response->json();
    }

    private function processReceipt($data)
{
    $orderId = $data['external_id'] ?? null;
    if (!$orderId) {
        Log::warning('Receipt without external_id', $data);
        return;
    }

    $order = Order::where('id', $orderId)->first();
    if (!$order) {
        Log::warning('Order not found', ['order_id' => $orderId]);
        return;
    }

    // Обновляем статус
    $order->status = 'paid';
    $order->receipt_sent = true;
    $order->save();

    // Синхронизация остатков
    if (isset($data['items']) && is_array($data['items'])) {
        foreach ($data['items'] as $item) {
            // Ищем товар по external_id (который мы передавали как ID товара)
            $productId = $item['external_id'] ?? null;
            if ($productId) {
                $product = Product::find($productId);
                if ($product) {
                    $product->decrement('stock', $item['quantity']);
                    Log::info("Списано {$item['quantity']} шт. товара {$product->name} (ID: {$productId})");
                } else {
                    Log::warning("Товар с ID {$productId} не найден в БД");
                }
            } else {
                // Если external_id нет, пробуем по названию (не надёжно)
                $product = Product::where('name', $item['name'])->first();
                if ($product) {
                    $product->decrement('stock', $item['quantity']);
                    Log::info("Списано {$item['quantity']} шт. товара {$product->name} по названию");
                } else {
                    Log::warning("Товар с названием {$item['name']} не найден");
                }
            }
        }
    }

    Log::info("Order $orderId marked as paid, stock updated");
}
}



// namespace App\Services;

// use App\Models\EvotorToken;
// use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Log;

// class EvotorReceiptService
// {
//     public function sendReceipt($order)
//     {
//         // Получаем токен (берём первый, можно привязать к кассе)
//         $tokenRecord = EvotorToken::first();
//         if (!$tokenRecord) {
//             Log::error('Нет токена Эвотор для отправки чека');
//             return false;
//         }
//         $bearerToken = $tokenRecord->token;

//         // Определяем тип оплаты
//         $paymentType = $this->getPaymentType($order->payment_method ?? 'cash');

//         // Формируем позиции
//         $positions = [];
//         foreach ($order->items as $item) {
//             $positions[] = [
//                 'position_uuid' => (string) Str::uuid(),
//                 'name' => $item->product_name,
//                 'price' => (float) $item->price,
//                 'quantity' => (float) $item->quantity,
//                 'measureName' => 'шт',
//                 'tax' => 'VAT_20', // измените при необходимости
//                 'settlement_method_type' => 'FULL',
//                 'type' => 'NORMAL',
//             ];
//         }

//         $payload = [
//             'receipt_uuid' => (string) Str::uuid(),
//             'client_email' => $order->customer_email,
//             'client_phone' => $order->customer_phone,
//             'payment_type' => $paymentType,
//             'should_print_receipt' => true,
//             'editable' => true,
//             'extra' => [
//                 'НомерЗаказа' => $order->id,
//             ],
//             'positions' => $positions,
//         ];

//         // Отправляем запрос
//         try {
//             $response = Http::withHeaders([
//                 'Authorization' => 'Bearer ' . $bearerToken,
//                 'AndroidId' => config('services.evotor.android_id', 'INTEGRATION-77777777777'),
//                 'Accept' => 'application/vnd.evotor.v2+json',
//                 'Content-Type' => 'application/vnd.evotor.v2+json',
//             ])->post('https://mobcashier.evotor.ru/api/v1/orders/create', $payload);

//             if ($response->successful()) {
//                 Log::info('Чек для заказа '.$order->id.' отправлен в Эвотор');
//                 return true;
//             } else {
//                 Log::error('Ошибка отправки чека: '.$response->status().' '.$response->body());
//                 return false;
//             }
//         } catch (\Exception $e) {
//             Log::error('Исключение при отправке чека: '.$e->getMessage());
//             return false;
//         }
//     }

//     private function getPaymentType($paymentMethod)
//     {
//         return in_array($paymentMethod, ['online', 'card']) ? 'CARD' : 'CASH';
//     }
// }