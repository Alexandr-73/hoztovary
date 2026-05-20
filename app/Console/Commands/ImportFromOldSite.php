<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use GuzzleHttp\Client;              // <-- ЭТО УЖЕ ЕСТЬ
use Symfony\Component\DomCrawler\Crawler;  // <-- ЭТО ТОЖЕ УЖЕ ЕСТЬ
use Illuminate\Support\Str;

class ImportFromOldSite extends Command
{
    protected $signature = 'import:old-site';
    protected $description = 'Импорт данных со старого сайта';

    public function handle()
    {
        $this->info('Начинаем импорт...');
        
        // Используем уже установленные пакеты!
        $client = new Client([
            'verify' => storage_path('app/certs/cacert.pem'),
            'timeout' => 30,
        ]);
        
        try {
            $response = $client->get('https://old-site.ru/catalog');
            $html = $response->getBody()->getContents();
            
            $crawler = new Crawler($html);
            
            // Парсим категории
            $crawler->filter('.category-item')->each(function ($node) {
                $name = $node->filter('.category-name')->text();
                $link = $node->filter('a')->attr('href');
                
                $this->info("Найдена категория: $name");
                
                // Сохраняем в базу
                Category::updateOrCreate(
                    ['old_url' => $link],
                    [
                        'name' => $name,
                        'slug' => Str::slug($name),
                        'is_active' => true,
                    ]
                );
            });
            
            $this->info('Импорт категорий завершен!');
            
        } catch (\Exception $e) {
            $this->error('Ошибка: ' . $e->getMessage());
        }
    }
}