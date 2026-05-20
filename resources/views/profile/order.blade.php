@extends('layouts.app')

@section('title', 'Заказ №' . $order->order_number)

@section('content')
    <div class="container py-4">
        <h1>Заказ №{{ $order->order_number }}</h1>

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
                <div class="card mb-3">
                    <div class="card-header">Информация о заказе</div>
                    <div class="card-body">
                        <p><strong>Дата:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
                        <p><strong>Статус:</strong> {{ $order->status }}</p>
                        <p><strong>Способ доставки:</strong>
                            {{ $order->delivery_type == 'pickup' ? 'Самовывоз' : 'Курьер' }}</p>
                        <p><strong>Адрес доставки:</strong> {{ $order->delivery_address ?? 'Самовывоз' }}</p>
                        <p><strong>Способ оплаты:</strong> {{ $order->payment_method == 'cash' ? 'Наличные' : 'Онлайн' }}
                        </p>
                        <p><strong>Статус оплаты:</strong> {{ $order->payment_status }}</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Состав заказа</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Товар</th>
                                    <th>Количество</th>
                                    <th>Цена</th>
                                    <th>Сумма</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->unit_price, 2, ',', ' ') }} ₽</td>
                                        <td>{{ number_format($item->total_price, 2, ',', ' ') }} ₽</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Итого:</th>
                                    <th>{{ number_format($order->total_amount, 2, ',', ' ') }} ₽</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
