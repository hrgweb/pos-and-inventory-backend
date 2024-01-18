<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\TransactionSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Transaction Session
Route::apiResource('transaction_sessions', TransactionSessionController::class);

// Product
Route::get('/products/lookup', [ProductController::class, 'lookup'])->name('products.lookup');
Route::apiResource('products', ProductController::class);

// Order
Route::apiResource('orders', OrderController::class);

// Testing
Route::apiResource('testing.comment', TestingController::class);//->shallow();