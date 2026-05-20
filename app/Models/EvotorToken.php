<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvotorToken extends Model
{
    protected $fillable = [
        'user_id',
        'token',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    // Получить токен по user_id
    public static function getTokenForUser(string $userId): ?string
    {
        $tokenRecord = self::where('user_id', $userId)->first();
        return $tokenRecord ? $tokenRecord->token : null;
    }

    // Проверить, действителен ли токен (если используется expires_at)
    public function isValid(): bool
    {
        return !$this->expires_at || $this->expires_at->isFuture();
    }
}
