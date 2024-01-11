<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Log;
use Hrgweb\SalesAndInventory\Domain\Sale\Data\SaleData;
use Hrgweb\SalesAndInventory\Domain\Sale\Services\SaleService;


class SaleController extends Controller
{
public function store(SaleData $sale)
    {
        try {
            return SaleService::make($sale->toArray())->save();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }
}
