<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    
    'customer_name',   // вместо 'name', если в таблице поле называется customer_name
    'customer_email',
    'customer_phone',
    'shipping_address',
    'payment_method',
    'subtotal',
    'discount',
    'total',
    'status',
    'delivery_distance_km',
    'delivery_price',
];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getPriceWithTaxAttribute()
{
    $product = $this->product;
    if ($product && $product->tax_rate) {
        return $this->price * (1 + $product->tax_rate / 100);
    }
    return $this->price;
}

public function product()
{
    return $this->belongsTo(Product::class);
}
}