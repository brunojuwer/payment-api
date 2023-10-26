<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;

Route::apiResource('/users', UserController::class);

Route::post('/payments/pix', [PaymentController::class, 'pix']);
Route::post('/payments/simple', [PaymentController::class, 'simple']);