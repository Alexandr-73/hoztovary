@extends('admin.layouts.app')

@section('title', 'Пользователи')

@section('content')
    <div class="container-fluid">
        <h1>Пользователи</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Администратор</th>
                        <th>Зарегистрирован</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->is_admin ? 'Да' : 'Нет' }}</td>
                            <td>{{ $user->created_at->format('d.m.Y') }}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user) }}"
                                    class="btn btn-sm btn-primary">Редактировать</a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Удалить пользователя?')"
                                        {{ $user->id == auth()->id() ? 'disabled' : '' }}>Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $users->links() }}
    </div>
@endsection
