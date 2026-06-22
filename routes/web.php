<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::delete('products/bulk-delete', [ProductController::class, 'bulkDelete'])->name('products.bulk-delete');
Route::resource('products', ProductController::class);
