<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{

    public function show($slug)
{
    $product = Product::where('slug', $slug)->firstOrFail();
    $product->price_with_tax = $product->price * (1 + ($product->tax_rate ?? 20) / 100);
    return view('product.show', compact('product'));
}
}
