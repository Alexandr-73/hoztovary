@extends('admin.layouts.app')

@section('title', 'Заказ #' . $order->id)

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Заказ #{{ $order->id }}</h1>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Назад к списку</a>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">Информация о заказе</div>
                        <div class="card-body">
                            <p><strong>Статус:</strong>
                                @switch($order->status)
                                    @case('pending')
                                        <span class="badge bg-warning">Ожидает</span>
                                    @break

                                    @case('processing')
                                        <span class="badge bg-info">В обработке</span>
                                    @break

                                    @case('shipped')
                                        <span class="badge bg-primary">Отправлен</span>
                                    @break

                                    @case('completed')
                                        <span class="badge bg-success">Завершён</span>
                                    @break

                                    @case('cancelled')
                                        <span class="badge bg-danger">Отменён</span>
                                    @break
                                @endswitch
                            </p>
                            <p><strong>Дата оформления:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
                            <p><strong>Общая сумма:</strong> {{ number_format($order->total, 2) }} ₽</p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Информация о клиенте</div>
                    <div class="card-body">
                        <p><strong>Имя:</strong> {{ $order->customer_name }}</p>
                        <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                        <p><strong>Телефон:</strong> {{ $order->customer_phone }}</p>
                        <p><strong>Адрес доставки:</strong> {{ $order->shipping_address }}</p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Изменить статус</div>
                    <div class="card-body">
                        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <select name="status" class="form-select">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Ожидает
                                    </option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>В
                                        обработке</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Отправлен
                                    </option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                                        Завершён</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Отменён
                                    </option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Обновить статус</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mt-4">
                    <div class="card-header">Состав заказа</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Товар</th>
                                        <th>Цена (с НДС) со скидкой</th>
                                        <th>Кол-во</th>
                                        <th>Сумма (с НДС) со скидкой</th>
                                        <th>Ставка НДС</th>
                                        <th>Сумма НДС</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ number_format($item->price_with_vat_and_discount, 2) }} ₽</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->total_with_vat, 2) }} ₽</td>
                                        <td>{{ $item->product->tax_rate ?? 20 }}%</td>
                                        <td>{{ number_format($item->vat_amount, 2) }} ₽</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end">Сумма без скидки (с НДС):</th>
                                        <th colspan="3">{{ number_format($order->subtotal * (1 + 20/100), 2) }} ₽</th>
                                    </tr>
                                    @if($order->discount > 0)
                                    <tr>
                                        <th colspan="3" class="text-end">Скидка ({{ round($order->discount / $order->subtotal * 100) }}%):</th>
                                        <th colspan="3">- {{ number_format($order->discount * (1 + 20/100), 2) }} ₽</th>
                                    </tr>
                                    @endif
                                    <tr class="table-success">
                                        <th colspan="3" class="text-end">Итого к оплате:</th>
                                        <th colspan="3"><strong>{{ number_format($order->total, 2) }} ₽</strong></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
