@extends('layouts.app')

@section('title', 'Оформление заказа')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Оформление заказа</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-md-7">
                <form method="POST" action="{{ route('order.store') }}" id="checkout-form">
                    @csrf

                    {{-- Контактная информация --}}
                    <div class="card mb-3">
                        <div class="card-header">Контактная информация</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">ФИО *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Телефон *</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Адрес доставки *</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2"
                                    required>{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Расчёт доставки (ползунок) --}}
                    <div class="card mb-3">
                        <div class="card-header">Расчёт стоимости доставки</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="distance_km" class="form-label">Расстояние от МО, Наро-Фоминск, ул. Жукова, 15
                                    (км):</label>
                                <input type="range" id="distance_slider" min="0" max="400" step="1"
                                    value="0" class="form-range">
                                <input type="number" id="distance_km" name="delivery_distance_km" class="form-control mt-2"
                                    value="0" step="1" min="0" max="400" style="width: 120px;">
                            </div>
                            <div id="delivery_info" class="alert alert-info">
                                <strong>Стоимость доставки:</strong> <span id="delivery_price_span">0.00</span> ₽
                            </div>
                            <p class="text-muted small">* Тарифы: до 20 км — 50 ₽/км; 21–50 км — 70 ₽/км + 1000 ₽; более 50
                                км — 90 ₽/км + 2100 ₽ + 1000 ₽.</p>
                        </div>
                    </div>

                    {{-- Способ оплаты --}}
                    <div class="card mb-3">
                        <div class="card-header">Способ оплаты</div>
                        <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_cash"
                                    value="cash" {{ old('payment_method') == 'cash' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="payment_cash">Наличными при получении</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_card"
                                    value="card" {{ old('payment_method') == 'card' ? 'checked' : '' }}>
                                <label class="form-check-label" for="payment_card">Банковской картой при получении</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_online"
                                    value="online" {{ old('payment_method') == 'online' ? 'checked' : '' }}>
                                <label class="form-check-label" for="payment_online">Онлайн-оплата (картой / СБП)</label>
                            </div>
                            @error('payment_method')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Комментарий --}}
                    <div class="card mb-3">
                        <div class="card-header">Комментарий к заказу</div>
                        <div class="card-body">
                            <textarea class="form-control @error('comment') is-invalid @enderror" name="comment" rows="3">{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">Оформить заказ</button>
                </form>
            </div>

            {{-- Корзина --}}
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">Ваш заказ</div>
                    <div class="card-body">
                        @if (isset($cartWithVat) && count($cartWithVat) > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Товар</th>
                                            <th>Кол-во</th>
                                            <th>Цена</th>
                                            <th>Сумма</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartWithVat as $item)
                                            <tr>
                                                <td>{{ $item['name'] }}</td>
                                                <td>{{ $item['quantity'] }}</td>
                                                <td>{{ number_format($item['price_with_vat'], 2) }} ₽</td>
                                                <td>{{ number_format($item['price_with_vat'] * $item['quantity'], 2) }} ₽
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3">Сумма без скидки:</th>
                                            <th>{{ number_format($subtotal ?? 0, 2) }} ₽</th>
                                        </tr>
                                        @if (($discount ?? 0) > 0)
                                            <tr>
                                                <th colspan="3">Скидка:</th>
                                                <th>- {{ number_format($discount ?? 0, 2) }} ₽</th>
                                            </tr>
                                        @endif
                                        <tr id="delivery-row" style="display: none;">
                                            <th colspan="3">Доставка (по тарифу):</th>
                                            <th id="delivery-price">0.00 ₽</th>
                                        </tr>
                                        <tr class="table-active">
                                            <th colspan="3">Итого к оплате:</th>
                                            <th id="totalWithDelivery"><strong>{{ number_format($totalWithVat ?? 0, 2) }}
                                                    ₽</strong></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">Корзина пуста.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Элементы управления доставкой
        const slider = document.getElementById('distance_slider');
        const kmInput = document.getElementById('distance_km');
        const deliveryPriceSpan = document.getElementById('delivery_price_span');
        const tableDeliveryPrice = document.getElementById('delivery-price');
        const deliveryRow = document.getElementById('delivery-row');
        const totalSpan = document.getElementById('totalWithDelivery');
        const hiddenDistance = document.getElementById('delivery_distance_km');

        let baseTotal = {{ $totalWithVat ?? 0 }};

        function updateDelivery() {
            let km = parseInt(kmInput.value) || 0;
            let price = 0;
            if (km <= 20) {
                price = km * 50;
            } else if (km <= 50) {
                price = (km - 20) * 70 + 1000;
            } else {
                price = (km - 50) * 90 + 2100 + 1000;
            }
            // Обновление в блоке расчёта
            if (deliveryPriceSpan) deliveryPriceSpan.innerText = price.toFixed(2);
            // Обновление в таблице заказа
            if (tableDeliveryPrice) tableDeliveryPrice.innerText = price.toFixed(2) + ' ₽';
            if (deliveryRow) deliveryRow.style.display = 'table-row';
            if (hiddenDistance) hiddenDistance.value = km;
            // Обновление итога
            let total = baseTotal + price;
            if (totalSpan) totalSpan.innerHTML = '<strong>' + total.toFixed(2) + ' ₽</strong>';
        }

        if (slider && kmInput) {
            slider.addEventListener('input', function() {
                kmInput.value = this.value;
                updateDelivery();
            });
            kmInput.addEventListener('input', function() {
                let val = parseInt(this.value);
                if (isNaN(val)) val = 0;
                val = Math.min(200, Math.max(0, val));
                this.value = val;
                slider.value = val;
                updateDelivery();
            });
            updateDelivery();
        } else {
            console.error('Элементы ползунка не найдены на странице');
        }
    });
</script>
