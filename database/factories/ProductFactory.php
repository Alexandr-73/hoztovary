<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->faker->words(3, true);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 100, 5000),
            'stock' => $this->faker->numberBetween(0, 200),
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id,
            'image' => null,
            'is_active' => true,
            'is_featured' => $this->faker->boolean(20),
        ];
    }
}