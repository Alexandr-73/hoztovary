@extends('layouts.app')

@section('title', 'Редактирование профиля')

@section('content')
    <div class="container py-4">
        <h1>Редактирование профиля</h1>

        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="{{ route('profile') }}" class="list-group-item list-group-item-action">Обзор</a>
                    <a href="{{ route('orders') }}" class="list-group-item list-group-item-action">Мои заказы</a>
                    <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action active">Личные
                        данные</a>
                    <a href="{{ route('profile.addresses') }}" class="list-group-item list-group-item-action">Адреса
                        доставки</a>
                </div>
            </div>

            <div class="col-md-9">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">Основная информация</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Имя *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Телефон</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                        </form>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">Смена пароля</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.password') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Текущий пароль</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                    id="current_password" name="current_password" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="new_password" class="form-label">Новый пароль</label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                    id="new_password" name="new_password" required>
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="new_password_confirmation" class="form-label">Подтверждение пароля</label>
                                <input type="password" class="form-control" id="new_password_confirmation"
                                    name="new_password_confirmation" required>
                            </div>

                            <button type="submit" class="btn btn-warning">Сменить пароль</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
