@extends('layouts.app')

@section('title', 'Заказ оформлен')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="card shadow-sm">
                    <div class="card-body py-5">
                        <i class="bi bi-check-circle-fill text-success display-1"></i>
                        <h1 class="mt-3">Заказ успешно оформлен!</h1>
                        <p class="lead">Спасибо за покупку.</p>
                        <p>Номер вашего заказа: <strong>#{{ $order->id }}</strong></p>
                        <p>На указанный email {{ $order->customer_email }} отправлена информация о заказе.</p>
                        <p>На указанный телефон {{ $order->customer_phone }} отправлена информация о заказе.</p>
                        <p>Сумма к оплате: <strong>{{ number_format($order->total, 2) }} ₽</strong></p>
                        <a href="{{ route('catalog') }}" class="btn btn-primary mt-3">Вернуться в каталог</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
