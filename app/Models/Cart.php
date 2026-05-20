<?php
// app/Models/Cart.php
namespace App\Models;

use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart_items';
    
    public static function getCart()
    {
        $sessionId = Session::getId();
        return self::with('product')
            ->where('session_id', $sessionId)
            ->get();
    }

    public static function addToCart($productId, $quantity = 1)
    {
        $product = Product::findOrFail($productId);
        $sessionId = Session::getId();

        $cartItem = self::where('session_id', $sessionId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            $cartItem = self::create([
                'session_id' => $sessionId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price
            ]);
        }

        return $cartItem;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
?>