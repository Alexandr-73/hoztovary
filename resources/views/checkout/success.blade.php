@extends('layouts.app')

@section('title', 'Заказ оформлен')

@section('content')
    <div class="container py-5 text-center">
        <div class="alert alert-success">
            <h2>Спасибо за заказ!</h2>
            <p>Ваш заказ №{{ $order->id }} успешно оформлен.</p>
            <p>В ближайшее время с вами свяжется менеджер для подтверждения.</p>
            <a href="{{ route('catalog') }}" class="btn btn-primary">Вернуться в каталог</a>
        </div>
    </div>
@endsection
