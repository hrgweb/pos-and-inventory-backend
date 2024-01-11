<?php

namespace App\Http\Controllers;

use Exception;
use Hrgweb\SalesAndInventory\Domain\TransactionSession\Services\TransactionSessionService;
use Illuminate\Support\Facades\Log;

class TransactionSessionController extends Controller
{
    public function store()
    {
        try {
            return TransactionSessionService::create();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }
}
