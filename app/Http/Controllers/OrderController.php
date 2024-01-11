<?php

namespace App\Http\Controllers;

use Exception;
use Hrgweb\SalesAndInventory\Domain\Order\Services\TransactionSession;
use Hrgweb\SalesAndInventory\Domain\Order\Data\OrderData;
use Hrgweb\SalesAndInventory\Domain\Order\Services\OrderService;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        try {
            return TransactionSession::generate();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }

    public function store(OrderData $order)
    {
        try {
            return OrderService::make($order->toArray())->save();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }
}
