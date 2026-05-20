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
        Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->string('customer_name');        // имя покупателя
    $table->string('customer_email');       // email
    $table->string('customer_phone');       // телефон (опционально)
    $table->text('shipping_address');       // адрес доставки
    $table->decimal('total', 10, 2);        // общая сумма заказа
    $table->string('status')->default('pending'); // статус (pending, paid, shipped, cancelled)
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
