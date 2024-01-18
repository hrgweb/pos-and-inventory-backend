<?php

use Illuminate\Http\Request;
use App\Models\TransactionSession;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use Inventory\Order\Services\OrderService;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionSessionController;

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

// Data
Route::get('/data', function (Request $request) {
    $transactionSessionNo = $request->input('transaction_session_no');

    return [
        'transaction_session' => TransactionSession::select(['session_no', 'status', 'grand_total', 'amount', 'change', 'created_at'])->where('session_no', $transactionSessionNo)->first(),
        'orders' => OrderService::fetch($transactionSessionNo),
        'suppliers' => [] // SupplierService::all()
    ];
})->name('data');

// Transaction Session
Route::apiResource('transaction_sessions', TransactionSessionController::class)->only(['store']);

// Product
Route::get('/products/lookup', [ProductController::class, 'lookup'])->name('products.lookup');
Route::apiResource('products', ProductController::class);

// Order
Route::apiResource('orders', OrderController::class);

// Supplier
Route::apiResource('suppliers', SupplierController::class);
