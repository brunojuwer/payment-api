<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);


Route::get('/', function () {
    return response()->json([
        'Success' => true,
    ]);
});