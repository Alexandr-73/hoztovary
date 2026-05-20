@extends('admin.layouts.app')

@section('title', 'Категории')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Категории</h1>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ Добавить категорию</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>URL-код</th>
                        <th>Описание</th>
                        <th>Активна</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ Str::limit($category->description, 50) }}</td>
                            <td>{{ $category->is_active ? 'Да' : 'Нет' }}</td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                    class="btn btn-sm btn-primary">Редактировать</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Удалить категорию?')">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $categories->links() }}
    </div>
@endsection
