<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\Product;

class EvotorWebhookController extends Controller
{
    public function handle(Request $request)
{
    Log::info('Evotor webhook received', [
        'headers' => $request->headers->all(),
        'payload' => $request->all()
    ]);

    $authHeader = $request->header('Authorization');
    $expectedToken = config('services.evotor.webhook_token');
    if ($expectedToken && $authHeader !== "Bearer {$expectedToken}") {
        Log::warning('Unauthorized webhook request', ['auth' => $authHeader]);
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $data = $request->input('data');
    if (!$data) {
        $data = $request->all();
    }

    // Извлекаем timestamp из корня запроса
    $timestamp = $request->input('timestamp');

    if ($this->isReceipt($data)) {
        $this->processReceipt($data, $timestamp);
    } else {
        Log::info('Received non-receipt event', $data);
    }

    return response()->json(['status' => 'ok'], 200);
}

    private function isReceipt($data)
    {
        // Определяем, что это чек: наличие external_id, типа SELL и т.п.
        return isset($data['external_id']) || (isset($data['type']) && in_array($data['type'], ['SELL', 'SELL_RETURN']));
    }

    // private function processReceipt($data)
    // {
    //     // Предположим, что в чеке есть external_id, который соответствует ID заказа в вашей системе
    //     $orderId = $data['external_id'] ?? null;
    //     if (!$orderId) {
    //         Log::warning('Receipt without external_id', $data);
    //         return;
    //     }

    //     $order = Order::where('id', $orderId)->first();
    //     if (!$order) {
    //         Log::warning('Order not found for receipt', ['order_id' => $orderId]);
    //         return;
    //     }

    //     // Обновляем статус заказа на "оплачен"
    //     $order->status = 'paid';
    //     $order->receipt_sent = true;
    //     $order->save();

    //     // Дополнительно можно сохранить данные чека в отдельную таблицу
    //     Log::info("Order $orderId marked as paid via Evotor webhook");
    // }

    private function processReceipt($data, $timestamp = null)
{
    if ($timestamp) {
        $dateTime = date('Y-m-d H:i:s', floor($timestamp / 1000));
        Log::info("Чек от {$dateTime}");
    }

    // остальной код (обновление статуса, списание остатков)
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

    // 1. Обновляем статус заказа
    $order->status = 'paid';
    $order->receipt_sent = true;
    $order->save();

    // 2. Синхронизация остатков
    if (isset($data['items']) && is_array($data['items'])) {
        foreach ($data['items'] as $item) {
            // Ищем товар по external_id (который мы передавали в чеке)
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
                // Запасной вариант: поиск по названию
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

    Log::info("Order $orderId обработан, остатки обновлены");
}
}