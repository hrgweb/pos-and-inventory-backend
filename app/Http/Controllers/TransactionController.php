<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inventory\Transaction\Services\TransactionService;

class TransactionController extends Controller
{
    public function void()
    {
        try {
            $transaction = TransactionService::make(request()->all())->void();
            return response()->json($transaction, 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }

    }
}
