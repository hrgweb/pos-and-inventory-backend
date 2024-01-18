<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inventory\Supplier\Dto\SupplierData;
use Inventory\Supplier\Services\SupplierService;

class SupplierController extends Controller
{
    public function store(SupplierData $data)
    {
        try {
            $product = SupplierService::make($data->toArray())->saveOrUpdate();
            return response()->json($product, 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }
}
