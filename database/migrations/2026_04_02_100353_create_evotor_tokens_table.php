<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evotor_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique(); // ID пользователя в Эвоторе (уникален)
            $table->text('token');               // Токен доступа
            $table->timestamp('expires_at')->nullable(); // Когда истекает (если известно)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evotor_tokens');
    }
};