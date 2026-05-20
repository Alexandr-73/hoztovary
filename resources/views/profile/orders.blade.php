@extends('layouts.app')

@section('title', 'Мои заказы')

@section('content')
    <div class="container py-4">
        <h1>Мои заказы</h1>

        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="{{ route('profile') }}" class="list-group-item list-group-item-action">Обзор</a>
                    <a href="{{ route('orders') }}" class="list-group-item list-group-item-action active">Мои заказы</a>
                    <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action">Личные данные</a>
                    <a href="{{ route('profile.addresses') }}" class="list-group-item list-group-item-action">Адреса
                        доставки</a>
                </div>
            </div>

            <div class="col-md-9">
                @if ($orders->count())
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>№ заказа</th>
                                    <th>Дата</th>
                                    <th>Товаров</th>
                                    <th>Сумма</th>
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                        <td>{{ $order->items->count() }}</td>
                                        <td>{{ number_format($order->total_amount, 2, ',', ' ') }} ₽</td>
                                        <td>{{ $order->status }}</td>
                                        <td><a href="{{ route('order.details', $order) }}"
                                                class="btn btn-sm btn-outline-primary">Подробнее</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $orders->links() }}
                @else
                    <p>У вас пока нет заказов.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
