@extends('admin.layouts.app')

@section('title', 'Панель управления')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Складская статистика за сегодня</h1>

    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Склад (начало дня)</div>
                <div class="card-body">
                    <h5 class="card-title">{{ number_format($totalStockValue, 2) }} ₽</h5>
                    <p class="card-text">Общая стоимость товаров в наличии</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Суточная распродажа</div>
                <div class="card-body">
                    <h5 class="card-title">{{ number_format($dailySales, 2) }} ₽</h5>
                    <p class="card-text">Заказы с чеками (статус не «отменён»)</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Суточный возврат</div>
                <div class="card-body">
                    <h5 class="card-title">{{ number_format($dailyReturns, 2) }} ₽</h5>
                    <p class="card-text">Отменённые заказы</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Склад (конец дня)</div>
                <div class="card-body">
                    <h5 class="card-title">{{ number_format($endStockValue, 2) }} ₽</h5>
                    <p class="card-text">С учётом проданных товаров</p>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-secondary mt-3">
        <strong>Примечание:</strong> Продажи считаются только по заказам, по которым успешно отправлен чек (поле `receipt_sent = true`). Возвраты – по отменённым заказам (статус `cancelled`). Стоимость склада – сумма `price * stock` для всех товаров.
    </div>
</div>
@endsection