<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inventory\TransactionSession\Services\TransactionSessionService;

class TransactionSessionController extends Controller
{
    public function store()
    {
        try {
            $orders = TransactionSessionService::create();
            return response()->json($orders, 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }
}
