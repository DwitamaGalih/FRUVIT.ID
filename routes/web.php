<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - FRUVIT.ID
|--------------------------------------------------------------------------
*/

// Customer Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{product}/detail', [MenuController::class, 'detail'])->name('menu.detail');

// Cart Routes
Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/json', [CartController::class, 'getJson'])->name('cart.json');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/proses', [CheckoutController::class, 'process'])->name('checkout.process');

// Order & Payment Routes
Route::get('/pesanan/{order_number}', [OrderController::class, 'show'])->name('order.show');
Route::post('/pesanan/{order_number}/upload-bukti', [OrderController::class, 'uploadProof'])->name('order.upload-proof');
Route::get('/lacak-pesanan', [OrderController::class, 'track'])->name('order.track');

// Loader.io Verification
Route::get('/loaderio-c9feb9a5e98849ee3b965349170ff54f', fn () => response('loaderio-c9feb9a5e98849ee3b965349170ff54f', 200, ['Content-Type' => 'text/plain']));
Route::get('/loaderio-c9feb9a5e98849ee3b965349170ff54f.txt', fn () => response('loaderio-c9feb9a5e98849ee3b965349170ff54f', 200, ['Content-Type' => 'text/plain']));

// Admin Authentication
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Protected Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/settings', [AdminDashboardController::class, 'updateSettings'])->name('settings.update');
    Route::get('/preview-email', function () {
        $order = \App\Models\Order::with('items')->latest()->first();
        if (! $order) {
            return 'Belum ada data pesanan di database untuk ditampilkan.';
        }
        return new \App\Mail\NewOrderNotification($order);
    })->name('preview-email');
    Route::get('/laporan/excel', [AdminOrderController::class, 'exportExcel'])->name('reports.excel');

    // Orders
    Route::get('/pesanan', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/pesanan/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    Route::post('/pesanan/{order}/upload-bukti', [AdminOrderController::class, 'uploadProof'])->name('orders.upload-proof');
    Route::delete('/pesanan/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

    // Products
    Route::get('/produk', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/produk/tambah', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/produk', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/produk/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/produk/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::post('/produk/{product}/toggle', [AdminProductController::class, 'toggleStatus'])->name('products.toggle');
    Route::delete('/produk/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
});
