<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->decimal('delivery_distance_km', 8, 2)->nullable()->after('discount');
        $table->decimal('delivery_price', 10, 2)->nullable()->after('delivery_distance_km');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('delivery_distance_km', 8, 2)->nullable()->after('discount');
            $table->decimal('delivery_price', 10, 2)->nullable()->after('delivery_distance_km');

        });
    }
};
