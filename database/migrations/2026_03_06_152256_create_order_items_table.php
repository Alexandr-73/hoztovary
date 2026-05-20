<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('order_id')->constrained()->onDelete('cascade');
    $table->foreignId('product_id')->constrained(); // если есть таблица products
    $table->string('product_name');           // можно сохранить название товара на момент заказа (на случай изменения цены/названия)
    $table->decimal('price', 10, 2);          // цена за единицу
    $table->integer('quantity');
    $table->decimal('subtotal', 10, 2);        // price * quantity
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
