@extends('layouts.app')

@section('title', 'Корзина')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Корзина</h1>

        {{-- @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif --}}

        @if (count($cartItems) > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Товар</th>
                            <th>Цена за ед. (с НДС)</th>
                            <th>Количество</th>
                            <th>Сумма (с НДС)</th>
                            <th>НДС (ставка)</th>
                            <th>Сумма НДС</th>
                            <th>Итого с НДС</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ number_format($item['price_with_tax'], 2) }} ₽</td>
                                <td>
                                    <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                            style="width:70px;" class="form-control d-inline-block">
                                        <button type="submit" class="btn btn-sm btn-secondary">Обновить</button>
                                    </form>
                                </td>
                                <td>{{ number_format($item['price_with_tax'] * $item['quantity'], 2) }} ₽</td>
                                <td>{{ $item['tax_rate'] }}%</td>
                                <td>{{ number_format($item['tax_amount'], 2) }} ₽</td>
                                <td>{{ number_format($item['total_with_tax'], 2) }} ₽</td>
                                <td>
                                    <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-active">
                            <th colspan="3" class="text-end">Сумма без скидки (без НДС):</th>
                            <th colspan="4">{{ number_format($subtotalWithoutTax, 2) }} ₽</th>
                        </tr>
                        @if ($discount > 0)
                            <tr>
                                <th colspan="3" class="text-end">Скидка:</th>
                                <th colspan="4">- {{ number_format($discount, 2) }} ₽ ({{ $coupon->discount_value }}% /
                                    {{ $coupon->code }})</th>
                            </tr>
                        @endif
                        <tr>
                            <th colspan="3" class="text-end">Сумма после скидки (без НДС):</th>
                            <th colspan="4">{{ number_format($totalAfterDiscountWithoutTax, 2) }} ₽</th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-end">НДС (суммарный):</th>
                            <th colspan="4">{{ number_format($totalVat, 2) }} ₽</th>
                        </tr>
                        <tr class="table-success">
                            <th colspan="3" class="text-end">Итого к оплате:</th>
                            <th colspan="4"><strong>{{ number_format($total, 2) }} ₽</strong></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <form action="{{ route('cart.apply-coupon') }}" method="POST" class="row g-2">
                        @csrf
                        <div class="col-auto">
                            <input type="text" name="coupon" class="form-control" placeholder="Промокод">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-outline-primary">Применить</button>
                        </div>
                    </form>
                    @if (session('coupon'))
                        <form action="{{ route('cart.remove-coupon') }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link text-danger">Удалить промокод</button>
                        </form>
                    @endif
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('checkout') }}" class="btn btn-success btn-lg">Оформить заказ</a>
                </div>
            </div>
        @else
            <p class="text-muted">Ваша корзина пуста.</p>
            <a href="{{ route('catalog') }}" class="btn btn-primary">Перейти в каталог</a>
        @endif
    </div>
@endsection
