<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Список категорий
     */
    public function index()
    {
        $categories = Category::paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Форма создания категории
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Сохранение новой категории
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $slug = $request->slug ?: Str::slug($request->name);
        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Категория добавлена');
    }

    /**
     * Форма редактирования категории
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Обновление категории
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $slug = $request->slug ?: Str::slug($request->name);
        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Категория обновлена');
    }

    /**
     * Удаление категории
     */
    public function destroy(Category $category)
    {
        // Проверка: если у категории есть товары, удаление запрещено
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Нельзя удалить категорию, в которой есть товары');
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Категория удалена');
    }
}
