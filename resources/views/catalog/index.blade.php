@extends('layouts.app')

@section('title', 'Каталог')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Каталог товаров</h1>

        {{-- Категории в стиле сайта "1000 мелочей" --}}
        @if ($categories->count())
            <div class="catalog_section_list row">
                @foreach ($categories as $category)
                    <div class="item_block col-md-6 col-sm-6 mb-4">
                        <div class="section_item item h-100 border rounded p-3">
                            <div class="row g-0">
                                <div class="col-auto">
                                    <a href="{{ route('category', $category->slug) }}" class="thumb">
                                        <img src="{{ $category->image ? asset('storage/' . $category->image) : asset('images/no_photo.png') }}"
                                            alt="{{ $category->name }}" style="max-width: 80px; max-height: 80px;"
                                            class="img-fluid">
                                    </a>
                                </div>
                                <div class="col ps-3">
                                    <h5 class="name mb-2">
                                        <a href="{{ route('category', $category->slug) }}"
                                            class="fw-bold text-decoration-none text-dark">
                                            {{ $category->name }}
                                        </a>
                                    </h5>
                                    @if ($category->children->count())
                                        <ul class="list-unstyled mb-0 small">
                                            @foreach ($category->children as $child)
                                                <li>
                                                    <a href="{{ route('category', $child->slug) }}"
                                                        class="text-decoration-none text-secondary">
                                                        {{ $child->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                            @if ($category->description)
                                <div class="desc mt-2 text-muted small">
                                    {{ $category->description }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Все товары --}}
        <h2 class="mt-5">Все товары</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @forelse($products as $product)
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x200?text=Нет+фото' }}"
                            class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                            <p class="fw-bold">{{ number_format($product->price * (1 + ($product->tax_rate ?? 20) / 100), 2, ',', ' ') }} ₽</p>
                            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-primary">Подробнее</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>Товаров пока нет.</p>
            @endforelse
        </div>

        {{-- Пагинация --}}
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
@endsection
