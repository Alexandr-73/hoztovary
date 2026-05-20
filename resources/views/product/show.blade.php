@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="container py-4">
        {{-- @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif --}}
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{ route('catalog') }}">Каталог</a></li>
                @if ($product->category)
                    <li class="breadcrumb-item"><a
                            href="{{ route('category', $product->category->slug) }}">{{ $product->category->name }}</a></li>
                @endif
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-6">
                @if ($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded"
                        alt="{{ $product->name }}">
                @else
                    <img src="https://via.placeholder.com/600x400?text=Нет+фото" class="img-fluid rounded" alt="Нет фото">
                @endif
            </div>
            <div class="col-md-6">
                <h1>{{ $product->name }}</h1>
                <p class="lead">{{ number_format($product->price_with_tax, 2, ',', ' ') }} ₽</p>
                <p>{{ $product->description }}</p>

                <p>
                    <strong>Наличие:</strong>
                    @if ($product->stock > 0)
                        <span class="text-success">В наличии ({{ $product->stock }} шт.)</span>
                    @else
                        <span class="text-danger">Нет в наличии</span>
                    @endif
                </p>

                @if ($product->stock > 0)
                    <form method="POST" action="{{ route('cart.add', $product) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Количество</label>
                            <input type="number" name="quantity" id="quantity" value="1" min="1"
                                max="{{ $product->stock }}" class="form-control" style="width: 100px;">
                        </div>
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="bi bi-cart-plus"></i> В корзину
                        </button>
                    </form>
                @else
                    <button class="btn btn-secondary btn-lg" disabled>Нет в наличии</button>
                @endif
            </div>
        </div>
    </div>
@endsection
