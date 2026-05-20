<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ParserService
{
    protected $client;
    
    public function __construct()
    {
        $this->client = new Client([
            'verify' => storage_path('app/certs/cacert.pem'), // Путь к сертификатам
            'timeout' => 30,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (compatible; Laravel Parser)',
            ]
        ]);
    }
    
    public function getCategories()
    {
        try {
            $response = $this->client->get('https://old-site.ru/catalog');
            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            Log::error('Ошибка парсинга категорий: ' . $e->getMessage());
            return null;
        }
    }
    
    public function getProducts($categoryUrl)
    {
        try {
            $response = $this->client->get($categoryUrl);
            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            Log::error('Ошибка парсинга товаров: ' . $e->getMessage());
            return null;
        }
    }
}