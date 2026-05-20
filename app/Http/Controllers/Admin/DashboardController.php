<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;          // импорт модели Order
use App\Models\Product;        // импорт модели Product
use App\Models\OrderItem;      // импорт модели OrderItem
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        // Склад на начало дня (по себестоимости)
        $totalStockValue = Product::sum(\DB::raw('cost * stock'));

        // Продажи за сегодня (сумма выручки по заказам с чеками, не отменённые)
        $dailySales = Order::where('receipt_sent', true)
            ->where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$today, $tomorrow])
            ->sum('total');

        // Возвраты (отменённые заказы)
        $dailyReturns = Order::where('status', 'cancelled')
            ->whereBetween('created_at', [$today, $tomorrow])
            ->sum('total');

        // Себестоимость проданных товаров (для корректного расчёта конечного склада)
        $dailyCostOfGoodsSold = OrderItem::whereHas('order', function ($q) use ($today, $tomorrow) {
                $q->where('receipt_sent', true)
                  ->where('status', '!=', 'cancelled')
                  ->whereBetween('created_at', [$today, $tomorrow]);
            })
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->sum(\DB::raw('products.cost * order_items.quantity'));

        // Склад на конец дня (по себестоимости)
        $endStockValue = $totalStockValue - $dailyCostOfGoodsSold;

        $totalUsers = User::count();

        return view('admin.dashboard.index', compact(
            'totalStockValue', 'dailySales', 'dailyReturns', 'endStockValue', 'totalUsers'
        ));
    }
}