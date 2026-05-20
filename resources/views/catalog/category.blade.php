@extends('layouts.app')

@section('title', $category->name)

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">{{ $category->name }}</h1>

        @if ($products->count())
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($products as $product)
                    <div class="col">
                        <div class="card h-100">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x200?text=Нет+фото' }}"
                                class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                <p class="fw-bold">{{ number_format($product->price, 2, ',', ' ') }} ₽</p>
                                <a href="{{ route('product.show', $product->slug) }}" class="btn btn-primary">Подробнее</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $products->links() }}
        @else
            <p>Товаров в этой категории пока нет.</p>
        @endif
    </div>
@endsection


