<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;


Route::post('/tokens', [AuthController::class, 'login'])->name('login');
Route::delete('/tokens', [AuthController::class, 'logout'])->name('logout')
  ->middleware('auth:sanctum');

Route::post('/users', [UserController::class, 'store'])->name('register');

Route::apiResource('/users', UserController::class)
  ->middleware('auth:sanctum')
  ->except('store');

Route::apiResource('/accounts', AccountController::class)
  ->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function() {
  Route::post('/payments/pix', [PaymentController::class, 'pix']);
  Route::post('/payments/simple', [PaymentController::class, 'simple']);
});