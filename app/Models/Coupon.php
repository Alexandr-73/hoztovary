<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'discount_type', 'discount_value', 'valid_from',
        'valid_until', 'usage_limit', 'used_count', 'is_active'
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];

    public function isValid()
    {
        $now = now();
        return $this->is_active &&
               ($this->valid_from ? $now >= $this->valid_from : true) &&
               ($this->valid_until ? $now <= $this->valid_until : true) &&
               ($this->usage_limit ? $this->used_count < $this->usage_limit : true);
    }
}
