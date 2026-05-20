@extends('layouts.app')

@section('title', 'Мои адреса')

@section('content')
    <div class="container py-4">
        <h1>Мои адреса доставки</h1>

        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="{{ route('profile') }}" class="list-group-item list-group-item-action">Обзор</a>
                    <a href="{{ route('orders') }}" class="list-group-item list-group-item-action">Мои заказы</a>
                    <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action">Личные данные</a>
                    <a href="{{ route('profile.addresses') }}" class="list-group-item list-group-item-action active">Адреса
                        доставки</a>
                </div>
            </div>

            <div class="col-md-9">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="mb-3">
                    <button class="btn btn-success" data-bs-toggle="collapse" data-bs-target="#addAddressForm">+ Добавить
                        новый адрес</button>
                </div>

                <div class="collapse mb-4" id="addAddressForm">
                    <div class="card card-body">
                        <form method="POST" action="{{ route('profile.addresses.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="address" class="form-label">Адрес</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                            <div class="mb-3">
                                <label for="comment" class="form-label">Комментарий (например, подъезд, этаж)</label>
                                <input type="text" class="form-control" id="comment" name="comment">
                            </div>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </form>
                    </div>
                </div>

                @if ($addresses->count())
                    <div class="row">
                        @foreach ($addresses as $address)
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <p>{{ $address->address }}</p>
                                        @if ($address->comment)
                                            <small class="text-muted">{{ $address->comment }}</small>
                                        @endif
                                        <div class="mt-2">
                                            <form action="{{ route('profile.addresses.destroy', $address) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-outline-danger">Удалить</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>У вас пока нет сохранённых адресов.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
