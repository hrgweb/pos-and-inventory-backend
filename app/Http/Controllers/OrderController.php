<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Inventory\Order\Dto\OrderData;
use Illuminate\Support\Facades\Log;
use Inventory\Order\Services\OrderService;

class OrderController extends Controller
{
    public function store(OrderData $data)
    {
        try {
            $orders = OrderService::make($data->toArray())->save();
            return response()->json($orders);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
