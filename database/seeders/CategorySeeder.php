<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Корневые категории
        $categories = [
            [
                'name' => 'Сад и огород',
                'slug' => 'sad-i-ogorod',
                'description' => 'Всё для сада и огорода',
                'children' => [
                    ['name' => 'Садовый инвентарь', 'slug' => 'sadovyy-inventar', 'description' => 'Лопаты, грабли, тачки'],
                    ['name' => 'Товары для рассады', 'slug' => 'tovary-dlya-rassady', 'description' => 'Горшки, грунты'],
                    ['name' => 'Средства защиты растений', 'slug' => 'sredstva-zashchity-rasteniy'],
                    ['name' => 'Полив и водоснабжение', 'slug' => 'poliv-i-vodosnabzhenie'],
                ],
            ],
            [
                'name' => 'Сантехника',
                'slug' => 'santekhnika',
                'description' => 'Смесители, унитазы, ванны',
                'children' => [
                    ['name' => 'Смесители', 'slug' => 'smesiteli'],
                    ['name' => 'Унитазы и биде', 'slug' => 'unitazy-i-bide'],
                    ['name' => 'Ванны и душевые кабины', 'slug' => 'vanny-i-dushevye-kabiny'],
                ],
            ],
            [
                'name' => 'Инструменты',
                'slug' => 'instrumenty',
                'description' => 'Электроинструмент, ручной инструмент, оснастка',
                'children' => [
                    ['name' => 'Электроинструмент', 'slug' => 'elektroinstrument'],
                    ['name' => 'Ручной инструмент', 'slug' => 'ruchnoy-instrument'],
                    ['name' => 'Пильные диски', 'slug' => 'pilnye-diski'],
                ],
            ],
            [
                'name' => 'Электротовары',
                'slug' => 'elektrotovary',
                'description' => 'Кабель, розетки, свет',
                'children' => [
                    ['name' => 'Кабель, провода, удлинители', 'slug' => 'kabel-provoda-udliniteli'],
                    ['name' => 'Розетки и выключатели', 'slug' => 'rozetki-i-vyklyuchateli'],
                    ['name' => 'Лампы и светильники', 'slug' => 'lampy-i-svetilniki'],
                ],
            ],
            [
                'name' => 'Строительные материалы',
                'slug' => 'stroitelnye-materialy',
                'description' => 'Сухие смеси, краски, изоляция',
                'children' => [],
            ],
            [
                'name' => 'Товары для дома',
                'slug' => 'tovary-dlya-doma',
                'description' => 'Уборка, хранение, текстиль',
                'children' => [],
            ],
            [
                'name' => 'Бытовая химия и гигиена',
                'slug' => 'bytovaya-khimiya-i-gigiyena',
                'description' => 'Стирка, уборка, средства гигиены',
                'children' => [],
            ],
        ];

        foreach ($categories as $parentData) {
            $parent = Category::create([
                'name' => $parentData['name'],
                'slug' => $parentData['slug'],
                'description' => $parentData['description'],
                'is_active' => true,
            ]);

            if (isset($parentData['children'])) {
                foreach ($parentData['children'] as $childData) {
                    Category::create([
                        'name' => $childData['name'],
                        'slug' => $childData['slug'],
                        'description' => $childData['description'] ?? null,
                        'parent_id' => $parent->id,
                        'is_active' => true,
                    ]);
                }
            }
        }
    }
}