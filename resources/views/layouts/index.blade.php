{{-- resources/views/catalog/index.blade.php --}}
@extends('layouts.app')

@section('title', $category ? $category->name : 'Каталог')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            @include('catalog.partials.sidebar', ['categories' => $categories])
        </div>
        <div class="col-md-9">
            <h1>{{ $category ? $category->name : 'Все товары' }}</h1>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="{{ route('catalog') }}" method="GET">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Поиск товаров..." value="{{ request('search') }}">
                    </form>
                </div>
                <div class="col-md-6">
                    <select class="form-select" onchange="location = this.value;">
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'new']) }}"
                                {{ request('sort') == 'new' ? 'selected' : '' }}>
                            Сначала новые
                        </option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}"
                                {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                            По возрастанию цены
                        </option>
                    </select>
                </div>
            </div>
            
            <div class="row">
                @foreach($products as $product)
                    <div class="col-lg-4 col-md-6 mb-4">
                        @include('catalog.partials.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
            
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection