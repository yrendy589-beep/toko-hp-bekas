<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('login', function () {
    return view('auth.select-role');
})->name('login');

Route::get('login/{role}', [AuthController::class, 'showLoginForm'])
    ->where('role', 'admin|customer')
    ->name('login.form');

Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.submit');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    // Orders
    Route::get('products/{product}/buy', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
    Route::post('orders/{order}/upload-proof', [OrderController::class, 'uploadProof'])->name('orders.upload-proof');
    Route::get('orders/{order}/thankyou', [OrderController::class, 'thankyou'])->name('orders.thankyou');
    Route::get('orders', [OrderController::class, 'customerIndex'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    // Admin orders
    Route::get('admin/orders', [OrderController::class, 'adminIndex'])->name('admin.orders.index');
    Route::post('admin/orders/{order}/verify', [OrderController::class, 'verify'])->name('admin.orders.verify');
    Route::delete('admin/orders/{order}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');
});

Route::delete('products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulk-delete');
Route::resource('products', ProductController::class);
