@extends('layouts.app')

@section('title', 'Оформление заказа')

@section('content')
    <div class="container py-4">
        <h1>Оформление заказа</h1>

        @if (count($cart) == 0)
            <div class="alert alert-warning">Корзина пуста. <a href="{{ route('catalog') }}">Вернуться в каталог</a></div>
        @else
            <div class="row">
                <div class="col-md-7">
                    <form action="{{ route('order.store') }}" method="POST" id="checkoutForm">
                        @csrf

                        {{-- Данные покупателя --}}
                        <div class="card mb-4">
                            <div class="card-header">Контактные данные</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label">ФИО *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', auth()->user()->name ?? '') }}"
                                        required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Телефон *</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone"
                                        value="{{ old('phone', auth()->user()->phone ?? '') }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email"
                                        value="{{ old('email', auth()->user()->email ?? '') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Доставка --}}
                        <div class="card mb-4">
                            <div class="card-header">Способ доставки</div>
                            <div class="card-body">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="delivery_type" id="delivery_pickup"
                                        value="pickup" checked>
                                    <label class="form-check-label" for="delivery_pickup">
                                        <strong>Самовывоз</strong><br>
                                        <small class="text-muted">г. Наро-Фоминск, ул. Маршала Жукова, 15</small>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="delivery_type"
                                        id="delivery_courier" value="courier">
                                    <label class="form-check-label" for="delivery_courier">
                                        <strong>Курьером по городу</strong><br>
                                        <small class="text-muted">Стоимость: 200 ₽ (бесплатно при заказе от 2000 ₽)</small>
                                    </label>
                                </div>

                                <div id="addressField" class="mt-3 d-none">
                                    <label for="address" class="form-label">Адрес доставки *</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="address" name="address" value="{{ old('address') }}">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Оплата --}}
                        <div class="card mb-4">
                            <div class="card-header">Способ оплаты</div>
                            <div class="card-body">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="payment_method" id="payment_cash"
                                        value="cash" checked>
                                    <label class="form-check-label" for="payment_cash">Наличными при получении</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="payment_online"
                                        value="online">
                                    <label class="form-check-label" for="payment_online">Онлайн оплата (карта)</label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg w-100">Подтвердить заказ</button>
                    </form>
                </div>

                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">Ваш заказ</div>
                        <div class="card-body">
                            <table class="table table-sm">
                                @foreach ($cart as $item)
                                    <tr>
                                        <td>{{ $item['name'] }} <br> <small class="text-muted">{{ $item['quantity'] }} ×
                                                {{ number_format($item['price'], 2, ',', ' ') }} ₽</small></td>
                                        <td class="text-end">
                                            {{ number_format($item['price'] * $item['quantity'], 2, ',', ' ') }} ₽</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th>Итого</th>
                                    <th class="text-end">{{ number_format($total, 2, ',', ' ') }} ₽</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const deliveryPickup = document.getElementById('delivery_pickup');
                const deliveryCourier = document.getElementById('delivery_courier');
                const addressField = document.getElementById('addressField');

                function toggleAddress() {
                    if (deliveryCourier.checked) {
                        addressField.classList.remove('d-none');
                        document.getElementById('address').required = true;
                    } else {
                        addressField.classList.add('d-none');
                        document.getElementById('address').required = false;
                    }
                }

                deliveryPickup.addEventListener('change', toggleAddress);
                deliveryCourier.addEventListener('change', toggleAddress);
            });
        </script>
    @endpush
@endsection
