<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Log;
use Hrgweb\SalesAndInventory\Domain\Supplier\Data\SupplierData;
use Hrgweb\SalesAndInventory\Domain\Supplier\Services\SupplierService;

class SupplierController extends Controller
{
    public function store(SupplierData $supplier)
    {
        try {
            return SupplierService::make($supplier->all())->save();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }
}
