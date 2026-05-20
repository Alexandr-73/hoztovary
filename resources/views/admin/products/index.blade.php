@extends('admin.layouts.app')

@section('title', 'Товары')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Товары</h1>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">+ Добавить товар</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Фото</th>
                        <th>Название</th>
                        <th>Категория</th>
                        <th>Цена</th>
                        <th>Остаток</th>
                        <th>Активен</th>
                        <th>Хит</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" width="50">
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? '-' }}</td>
                            <td>{{ number_format($product->price, 2) }} ₽</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->is_active ? 'Да' : 'Нет' }}</td>
                            <td>{{ $product->is_featured ? 'Да' : 'Нет' }}</td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product) }}"
                                    class="btn btn-sm btn-primary">Редактировать</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Удалить?')">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $products->links() }}
    </div>
@endsection
