<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        $categories = Category::with('children')->whereNull('parent_id')->get();
        $products = Product::paginate(20);
        foreach ($products as $product) {
        $product->price_with_tax = $product->price * (1 + ($product->tax_rate ?? 20) / 100);
        }
        return view('catalog.index', compact('products', 'categories'));    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->with('children')->firstOrFail();
        $products = $category->products()->where('is_active', true)->paginate(12);
        return view('catalog.category', compact('category', 'products'));
    }
}

    