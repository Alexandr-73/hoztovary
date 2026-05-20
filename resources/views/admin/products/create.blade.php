@extends('admin.layouts.app')

@section('title', 'Добавление товара')

@section('content')
    <div class="container-fluid">
        <h1>Добавление товара</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mb-3">Назад</a>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Название</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">URL-код (оставьте пустым для автогенерации)</label>
                <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                    value="{{ old('slug') }}">
                @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Категория</label>
                <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror"
                    required>
                    <option value="">Выберите категорию</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Цена (₽)</label>
                <input type="number" step="0.01" name="price" id="price"
                    class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Остаток на складе</label>
                <input type="number" name="stock" id="stock"
                    class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', 0) }}" required>
                @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Описание</label>
                <textarea name="description" id="description" rows="5"
                    class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Изображение</label>
                <input type="file" name="image" id="image"
                    class="form-control @error('image') is-invalid @enderror">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1"
                    {{ old('is_active', true) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Активен (отображать на сайте)</label>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1"
                    {{ old('is_featured') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_featured">Рекомендуемый (на главной)</label>
            </div>

            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
@endsection
