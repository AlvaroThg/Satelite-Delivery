<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Satélite Delivery — API Routes
|--------------------------------------------------------------------------
| Prefix automático: /api  (configurado en bootstrap/app.php)
*/

// ── Auth (público) ────────────────────────────────────────────────────────
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login',    [AuthController::class, 'login']);
});

// ── Rutas protegidas con Sanctum ──────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me',      [AuthController::class, 'me']);
    });

    // Stores
    Route::apiResource('stores', StoreController::class)
         ->only(['index', 'show', 'store', 'update']);

    // Products (anidados bajo stores)
    Route::get('stores/{store}/products',  [ProductController::class, 'index']);
    Route::post('stores/{store}/products', [ProductController::class, 'store']);
    Route::put('products/{product}',       [ProductController::class, 'update']);
    Route::delete('products/{product}',    [ProductController::class, 'destroy']);

    // Orders
    Route::get('orders',                         [OrderController::class, 'index']);
    Route::post('orders',                        [OrderController::class, 'store']);
    Route::get('orders/{order}',                 [OrderController::class, 'show']);
    Route::patch('orders/{order}/status',        [OrderController::class, 'updateStatus']);
});
