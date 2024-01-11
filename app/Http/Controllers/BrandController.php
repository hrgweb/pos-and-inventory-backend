<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Log;
use Hrgweb\SalesAndInventory\Domain\Brand\Data\BrandData;
use Hrgweb\SalesAndInventory\Domain\Brand\Services\BrandService;

class BrandController extends Controller
{
    public function store(BrandData $supplier)
    {
        try {
            return BrandService::make($supplier->all())->save();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }
}
