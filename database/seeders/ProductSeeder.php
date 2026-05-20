<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        // Пример товара для категории "Кабель, провода, удлинители"
        $cableCategory = Category::where('slug', 'kabel-provoda-udliniteli')->first();
        if ($cableCategory) {
            Product::create([
                'name' => 'Кабель Камит ВВГпнг(А)-LS 3x2.5 100 м ГОСТ',
                'slug' => 'kabel-kamit-vvgpng-a-ls-3x2-5-100-m-gost',
                'description' => 'Кабель силовой, не распространяющий горение, 3×2,5 мм², длина 100 м',
                'price' => 111.43,
                'stock' => 100,
                'category_id' => $cableCategory->id,
                'image' => 'products/catKabel.png',
                'is_active' => true,
                'is_featured' => false,
            ]);
        }

        // Пример товара для категории "Смесители"
        $mixerCategory = Category::where('slug', 'smesiteli')->first();
        if ($mixerCategory) {
            Product::create([
                'name' => 'Смеситель для раковины AM.PM Flash однорычажный хром',
                'slug' => 'smesitel-ampm-flash',
                'description' => 'Однорычажный смеситель для раковины, цвет хром, гарантия 5 лет.',
                'price' => 3500.00,
                'stock' => 15,
                'category_id' => $mixerCategory->id,
                'image' => 'products/mixer.jpg',
                'is_active' => true,
                'is_featured' => true,
            ]);
        }

        // Пример товара для категории "Пильные диски"
        $sawCategory = Category::where('slug', 'pilnye-diski')->first();
        if ($sawCategory) {
            Product::create([
                'name' => 'Диск отрезной по мультиматериалам Trio-Diamond MM904 210x32/30x2 мм',
                'slug' => 'disk-otreznoy-trio-diamond-mm904',
                'description' => 'Отрезной диск для резки различных материалов.',
                'price' => 1067.00,
                'stock' => 50,
                'category_id' => $sawCategory->id,
                'image' => 'products/disk.jpg',
                'is_active' => true,
                'is_featured' => false,
            ]);
        }

        // Можно добавить ещё несколько товаров с помощью factory
        Product::factory(20)->create(); // если есть factory
    }
}