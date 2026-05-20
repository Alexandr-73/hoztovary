@extends('admin.layouts.app')

@section('title', 'Заказы')

@section('content')
    <div class="container-fluid">
        <h1>Заказы</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Клиент</th>
                        <th>Сумма</th>
                        <th>Статус</th>
                        <th>Дата</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->customer_name }}<br><small>{{ $order->customer_phone }}</small></td>
                            <td>{{ number_format($order->total, 2) }} ₽</td>
                            <td>
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
                            </td>
                            <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info">Просмотр</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $orders->links() }}
    </div>
@endsection
