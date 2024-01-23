<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inventory\Supplier\Dto\SupplierData;
use Inventory\Supplier\Services\SupplierService;

class SupplierController extends Controller
{
    public function index()
    {
        try {
            return SupplierService::make()->fetch();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }

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

    public function update(Request $request, int $id)
    {
        try {
            $data = SupplierData::from(array_merge($request->all(), ['id' => $id]));

            $supplier = SupplierService::make($data->toArray())->saveOrUpdate();
            return response()->json($supplier, 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            return SupplierService::make(request()->all())->remove($id);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }
}
