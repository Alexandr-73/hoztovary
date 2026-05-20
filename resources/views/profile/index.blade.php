@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
    <div class="container py-4">
        <h1>Личный кабинет</h1>

        <div class="row">
            <div class="col-md-4">
                <div class="list-group">
                    <a href="{{ route('profile') }}" class="list-group-item list-group-item-action active">Обзор</a>
                    <a href="{{ route('orders') }}" class="list-group-item list-group-item-action">Мои заказы</a>
                    <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action">Личные данные</a>
                    <a href="{{ route('profile.addresses') }}" class="list-group-item list-group-item-action">Адреса
                        доставки</a>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Добро пожаловать, {{ auth()->user()->name }}!</div>
                    <div class="card-body">
                        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                        <p><strong>Телефон:</strong> {{ auth()->user()->phone ?? 'Не указан' }}</p>
                        <p><strong>Дата регистрации:</strong> {{ auth()->user()->created_at->format('d.m.Y') }}</p>

                        @if ($recentOrders->count())
                            <h5 class="mt-4">Последние заказы</h5>
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>№ заказа</th>
                                        <th>Дата</th>
                                        <th>Сумма</th>
                                        <th>Статус</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentOrders as $order)
                                        <tr>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->created_at->format('d.m.Y') }}</td>
                                            <td>{{ number_format($order->total_amount, 2, ',', ' ') }} ₽</td>
                                            <td>{{ $order->status }}</td>
                                            <td><a href="{{ route('order.details', $order) }}">Подробнее</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
