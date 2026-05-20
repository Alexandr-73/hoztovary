@extends('layouts.app')

@section('content')
    {{-- Баннер с градиентом --}}
    <div class="bg-primary bg-gradient text-white py-5">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Добро пожаловать в магазин «Хозтовары»</h1>
            <p class="lead">Всё для дома, уборки и дачи – по доступным ценам!</p>
            <a href="{{ route('catalog') }}" class="btn btn-warning btn-lg mt-3">
                <i class="bi bi-basket"></i> Перейти в каталог
            </a>
        </div>
    </div>

    {{-- Преимущества с иконками и цветными карточками --}}
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center bg-light">
                    <div class="card-body">
                        <i class="bi bi-truck display-3 text-primary"></i>
                        <h4 class="mt-3">
                            <a href="{{ route('delivery') }}" class="text-decoration-none">Быстрая доставка</a>
                        </h4>
                        <p class="text-muted">Доставим заказ в день оформления</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center bg-light">
                    <div class="card-body">
                        <i class="bi bi-shield-check display-3 text-success"></i>
                        <h4 class="mt-3">
                            <a href="{{ route('quality') }}" class="text-decoration-none">Качество товаров</a>
                        </h4>
                        <p class="text-muted">Только проверенные бренды</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center bg-light">
                    <div class="card-body">
                        <i class="bi bi-hand-thumbs-up display-3 text-warning"></i>
                        <h4 class="mt-3">
                            <a href="{{ route('parking') }}" class="text-decoration-none">Удобная парковка</a>
                        </h4>
                        <p class="text-muted">Для всех, включая людей с инвалидностью</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Популярные категории (если есть) --}}
        @if (isset($categories) && $categories->count())
            <div class="bg-light py-5">
                <div class="container">
                    <h2 class="text-center mb-4">Популярные категории</h2>
                    <div class="row">
                        @foreach ($categories as $category)
                            <div class="col-md-3 mb-3">
                                <div class="card h-100 text-center border-primary">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $category->name }}</h5>
                                        <a href="{{ route('category', $category->slug) }}"
                                            class="btn btn-outline-primary btn-sm">Смотреть</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @endsection
