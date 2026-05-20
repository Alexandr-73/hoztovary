<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'price',
        'quantity',
        'subtotal',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

   // Связь с товаром (если ещё нет)
public function product()
{
    return $this->belongsTo(Product::class);
}

// Цена без НДС с учётом скидки (пропорционально)
public function getPriceWithDiscountAttribute()
{
    $order = $this->order;
    if ($order && $order->subtotal > 0 && $order->discount > 0) {
        $discountFactor = ($order->subtotal - $order->discount) / $order->subtotal;
        return $this->price * $discountFactor;
    }
    return $this->price;
}

// Цена с НДС с учётом скидки
public function getPriceWithVatAndDiscountAttribute()
{
    $priceWithDiscount = $this->getPriceWithDiscountAttribute();
    $taxRate = $this->product->tax_rate ?? 20;
    return $priceWithDiscount * (1 + $taxRate / 100);
}

// Сумма с НДС с учётом скидки
public function getTotalWithVatAttribute()
{
    return $this->getPriceWithVatAndDiscountAttribute() * $this->quantity;
}

// Сумма НДС для позиции
public function getVatAmountAttribute()
{
    $priceWithDiscount = $this->getPriceWithDiscountAttribute();
    $taxRate = $this->product->tax_rate ?? 20;
    return $priceWithDiscount * $taxRate / 100 * $this->quantity;
}

}