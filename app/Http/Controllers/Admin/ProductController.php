<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;  // добавлен импорт
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $slug = $request->slug ?: Str::slug($request->name);
        $data = $request->except('image');
        $data['slug'] = $slug;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Товар добавлен');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        $slug = $request->slug ?: Str::slug($request->name);
        $data = $request->except('image');
        $data['slug'] = $slug;

        // Обработка множественных изображений (галерея)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $product->images()->create([
                    'path' => $path,
                    'sort_order' => ($product->images()->max('sort_order') ?? 0) + 1,
                ]);
            }
        }

        // Обработка одиночного изображения (старое поле)
        if ($request->hasFile('single_image')) {
            $path = $request->file('single_image')->store('products', 'public');
            $data['image'] = $path;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Товар обновлён');
    }

    public function destroy(Product $product)
    {
        // Удаляем связанные изображения из галереи
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }
        // Удаляем одиночное изображение, если есть
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Товар удалён');
    }

    // Сортировка изображений галереи
    public function sortImages(Request $request, Product $product)
    {
        $order = $request->order;
        foreach ($order as $index => $imageId) {
            ProductImage::where('id', $imageId)->update(['sort_order' => $index]);
        }
        return response()->json(['success' => true]);
    }

    // Удаление одного изображения из галереи
    public function destroyImage(Product $product, $imageId)
    {
        $image = ProductImage::findOrFail($imageId);
        Storage::disk('public')->delete($image->path);
        $image->delete();
        return response()->json(['success' => true]);
    }
}