<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;
use Hrgweb\SalesAndInventory\Domain\Product\Data\ProductData;
use Hrgweb\SalesAndInventory\Domain\Product\Services\ProductService;

class ProductController extends Controller
{
    public function index(Request $request): PaginatedDataCollection
    {
        try {
            return ProductService::make($request->all())->fetch();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }

    public function lookup(Request $request): DataCollection
    {
        try {
            return ProductService::make($request->all())->lookup();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }

    public function store(ProductData $data)
    {
        try {
            return ProductService::make($data->toArray())->save();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }

    public function update(ProductData $data, int $id)
    {
        try {
            return ProductService::make($data->toArray())->update($id);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            return ProductService::make(request()->all())->remove($id);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }
}
