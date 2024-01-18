<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inventory\Product\Dto\ProductData;
use Inventory\Product\Services\ProductService;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $products = ProductService::make()->list();
            return response()->json($products, 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function store(ProductData $data)
    {
        try {
            $product = ProductService::make($data->toArray())->saveOrUpdate();
            return response()->json($product, 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }

    public function update(Request $request, Product $product)
    {
        try {
            $data = ProductData::from(array_merge($product->toArray(), $request->all()));

            $result = ProductService::make($data->toArray())->saveOrUpdate();
            return response()->json($result->toArray(), 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            ProductService::make(['id' => $id])->remove();
            return response()->json(['success' => true], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }
}
