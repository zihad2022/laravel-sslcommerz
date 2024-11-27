<?php

use Devzihad\LaravelSslcommerz\Http\Controllers\SslCommerzController;
use Illuminate\Support\Facades\Route;

// =======================================//

Route::post('/payment/initiate', [SslCommerzController::class, 'paymentInitiate']);
Route::post('/payment/callback', [SslCommerzController::class, 'paymentCallback'])->name('sslcommerz.callback');
