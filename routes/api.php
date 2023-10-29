<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;

Route::post('/tokens', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => 'auth:sanctum'], function() {
  Route::delete('/tokens', [AuthController::class, 'logout'])->name('logout');

  Route::apiResource('/users', UserController::class);
  Route::post('/payments/pix', [PaymentController::class, 'pix']);
  Route::post('/payments/simple', [PaymentController::class, 'simple']);
});