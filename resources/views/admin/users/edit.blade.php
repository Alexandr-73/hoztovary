@extends('admin.layouts.app')

@section('title', 'Редактирование пользователя')

@section('content')
    <div class="container-fluid">
        <h1>Редактирование пользователя: {{ $user->name }}</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mb-3">Назад</a>

        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Имя</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email"
                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}"
                    required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Новый пароль (оставьте пустым, если не нужно менять)</label>
                <input type="password" name="password" id="password"
                    class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_admin" id="is_admin" class="form-check-input" value="1"
                    {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_admin">Администратор</label>
            </div>

            <button type="submit" class="btn btn-primary">Обновить</button>
        </form>
    </div>
@endsection
