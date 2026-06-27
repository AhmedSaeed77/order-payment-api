<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;


Route::get('/test', function () {
    return response()->json([
        'message' => 'API Working'
    ]);
});


Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout',[AuthController::class,'logout']);
    });
});

Route::apiResource('orders',OrderController::class)->middleware('auth:api');

Route::get('payments/index',[PaymentController::class,'index'])->middleware('auth:api');

Route::post('payments/process',[PaymentController::class,'process'])->middleware('auth:api');


