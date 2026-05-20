@extends('admin.layouts.app')

@section('title', 'Редактирование категории')

@section('content')
    <div class="container-fluid">
        <h1>Редактирование категории: {{ $category->name }}</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary mb-3">Назад</a>

        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Название</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $category->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">URL-код (оставьте пустым для автогенерации)</label>
                <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                    value="{{ old('slug', $category->slug) }}">
                @error('slug')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Описание</label>
                <textarea name="description" id="description" rows="5"
                    class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1"
                    {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Активна (отображать на сайте)</label>
            </div>

            <button type="submit" class="btn btn-primary">Обновить</button>
        </form>
    </div>
@endsection
