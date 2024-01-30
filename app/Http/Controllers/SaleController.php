<?php

namespace App\Http\Controllers;

use Exception;
use Inventory\Sale\Dto\SaleData;
use Illuminate\Support\Facades\Log;
use Inventory\Sale\Services\SaleService;

class SaleController extends Controller
{
    public function store(SaleData $data)
    {
        try {
            $data = $data->toArray();

            if ($data['amount'] < $data['grand_total']) {
                $errorMsg = 'amount must greater than grand total.';
                Log::warning($errorMsg);
                return response()->json(['error' => true, 'errorMsg' => $errorMsg], 402);
            }

            $result = SaleService::make($data)->save();
            return response()->json($result, 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }
}
