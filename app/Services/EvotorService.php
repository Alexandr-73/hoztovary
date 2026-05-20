<?php

// namespace App\Services;

// use App\Models\EvotorToken;
// use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Cache;

// class EvotorService
// {
//     protected $apiUrl;
//     protected $apiKey;
//     protected $token;

//     public function __construct()
//     {
//         // Получаем токен из кэша (куда сохраняет EvotorWebhookController) или из БД
//         // $this->token = Cache::get('evotor_user_token');
//         $this->token = 'f35c08ea-b39f-408d-9982-1f735038d712';
//         if (!$this->token) {
//             $tokenRecord = EvotorToken::first();
//             $this->token = $tokenRecord ? $tokenRecord->token : null;
//         }
//         $this->apiUrl = config('services.evotor.api_url', 'https://api.evotor.ru');
//         $this->apiKey = config('services.evotor.api_key');
//     }

//     public function createReceipt($data)
//     {
//         if (!$this->token) {
//             throw new \Exception('Нет токена Эвотор. Сначала получите токен через /evotor/webhook/token');
//         }

//         $url = $this->apiUrl . '/api/v2/receipts';   // добавили /api/
//         // $url = 'https://api.evotor.ru/v2/receipts'; // без /api/

//         $response = Http::withHeaders([
//             'Authorization' => 'Bearer ' . $this->token,
//             'Content-Type' => 'application/json',
//             'Accept' => 'application/vnd.evotor.v2+json',
//         ])->post($url, $data);

//         // Временное логирование ответа
//     \Log::info('Evotor response', [
//         'status' => $response->status(),
//         'body' => $response->body(),
//         'json' => $response->json()
//     ]);

//         if (!$response->successful()) {
//             throw new \Exception('Ошибка API Эвотор: ' . $response->body());
//         }

//         return $response->json();
//     }
// }