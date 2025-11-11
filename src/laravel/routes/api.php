<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;

Route::prefix('v1')->group(function () {
    Route::apiResource('clients', ClientController::class);
    Route::get('clients/{client}/orders', [ClientController::class, 'orders'])->name('clients.orders');

    Route::apiResource('products', ProductController::class);

    Route::apiResource('orders', OrderController::class)->only(['index','store','show','destroy']);
});