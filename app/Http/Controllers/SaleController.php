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
            $result = SaleService::make($data->toArray())->save();
            return response()->json($result, 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }
}
