<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\EvotorTokenController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\EvotorWebhookController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

// ==================== ПУБЛИЧНЫЕ МАРШРУТЫ ====================
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/reviews', [PageController::class, 'reviews'])->name('reviews');
Route::get('/photos', [PageController::class, 'photos'])->name('photos');
Route::get('/contacts', [PageController::class, 'contacts'])->name('contacts');
Route::get('/delivery', [PageController::class, 'delivery'])->name('delivery');
Route::get('/quality', [PageController::class, 'quality'])->name('quality');
Route::get('/parking', [PageController::class, 'parking'])->name('parking');
Route::get('/developer', [PageController::class, 'developer'])->name('developer');
Route::post('/developer-contact', [PageController::class, 'storeContact'])->name('developer.contact');

// Каталог товаров
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
Route::get('/category/{slug}', [CatalogController::class, 'category'])->name('category');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

// Корзина
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{product}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{product}', [CartController::class, 'remove'])->name('remove');
    Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('apply-coupon');
    Route::delete('/remove-coupon', [CartController::class, 'removeCoupon'])->name('remove-coupon');
});

// Оформление заказа
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/orders', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/success/{order}', [OrderController::class, 'success'])->name('order.success');

// ==================== АДМИНКА ====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('orders', AdminOrderController::class);
    Route::resource('users', UserController::class);

    Route::post('/products/{product}/images/sort', [AdminProductController::class, 'sortImages'])->name('admin.products.images.sort');
    // Route::delete('/products/{product}/images/{image}', [AdminProductController::class, 'destroyImage'])->name('admin.products.images.destroy');
    
    // Управление изображениями товаров (галерея)
    Route::post('/products/{product}/images/sort', [App\Http\Controllers\Admin\ProductController::class, 'sortImages'])->name('products.images.sort');
    Route::delete('/products/{product}/images/{image}', [App\Http\Controllers\Admin\ProductController::class, 'destroyImage'])->name('products.images.destroy');

    // Кастомный маршрут для обновления статуса заказа
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
}); // <-- Закрывающая скобка группы админки

// ==================== ЭВОТОР (вебхуки) ====================
// Этот маршрут должен быть снаружи группы админки, так как он публичный
// Route::post('/evotor/webhook/token', [EvotorWebhookController::class, 'storeToken'])->name('evotor.token');
// Route::post('/api/evotor/webhook', [EvotorWebhookController::class, 'handle']);

// ==================== АВТОРИЗОВАННЫЕ ПОЛЬЗОВАТЕЛИ ====================
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('catalog');
    })->name('dashboard');
});

// ==================== ТЕСТОВЫЙ МАРШРУТ ДЛЯ ЭВОТОР OAuth ====================
Route::get('/test-oauth', function () {
    $response = Http::asForm()->post('https://oauth.evotor.ru/oauth/token', [
        'client_id' => config('services.evotor.client_id'),
        'client_secret' => config('services.evotor.client_secret'),
        'grant_type' => 'client_credentials',
    ]);
    return response()->json([
        'status' => $response->status(),
        'body' => $response->body(),
        'json' => $response->json(),
    ]);
});
 Route::get('/test', fn() => 'test');
// ==================== ПОДКЛЮЧЕНИЕ МАРШРУТОВ АУТЕНТИФИКАЦИИ ====================
// Убедитесь, что файл routes/auth.php существует



Route::get('/generate-qr', function () {
    $qr = QrCode::format('svg')
        ->size(800)
        ->margin(2)
        ->errorCorrection('H')
        ->generate('https://hoztovary.ru.tuna.am/catalog');
    return response($qr)->header('Content-Type', 'image/svg+xml');
});

require __DIR__.'/auth.php';