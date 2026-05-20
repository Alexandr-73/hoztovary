<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncProductsToEvotor extends Command
{
    protected $signature = 'evotor:sync-products';
    protected $description = 'Загружает товары из БД в облако Эвотор';

    public function handle()
    {
        $token = config('services.evotor.api_key');
        if (!$token) {
            $this->error('EVOTOR_API_KEY не задан в .env');
            return 1;
        }

        $products = Product::all();
        $this->info("Найдено товаров: " . $products->count());

        foreach ($products as $product) {
            $data = [
                'name' => $product->name,
                'price' => (int) ($product->price * 100), // в копейках
                'quantity' => $product->stock,
                'measure_name' => 'шт',
                'tax' => ($product->tax_rate == 20) ? 'VAT_20' : 'NO_VAT',
                'type' => 'NORMAL',
            ];

            if ($product->evotor_id) {
                $url = "https://api.evotor.ru/api/v1/products/{$product->evotor_id}";
                $method = 'PUT';
            } else {
                $url = 'https://api.evotor.ru/api/v1/products';
                $method = 'POST';
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/vnd.evotor.v2+json',
            ])->$method($url, $data);

            if ($response->successful()) {
                $evotorProduct = $response->json();
                if ($method === 'POST') {
                    $product->evotor_id = $evotorProduct['id'];
                    $product->save();
                }
                $this->info("✅ Товар {$product->name} синхронизирован");
            } else {
                $this->error("❌ Ошибка: {$product->name} - HTTP {$response->status()} - " . $response->body());
                if ($response->status() === 403) {
                    $this->error("   Возможно, у токена нет права product:write. Обратитесь в поддержку Эвотор.");
                }
            }
        }
        $this->info("Синхронизация завершена.");
        return 0;
    }
}