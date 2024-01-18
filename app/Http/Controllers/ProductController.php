<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Inventory\Product\Dto\ProductData;
use Inventory\Product\Services\ProductService;
use Symfony\Component\HttpFoundation\Response;

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
            return response()->json(['success' => false], 500);
        }
    }

    public function update(ProductData $data)
    {
        try {
            $data = ProductService::make($data->toArray())->saveOrUpdate();
            return response()->json(array_merge($data->toArray(), ['success' => true]), 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            ProductService::make(['id' => $id])->remove();
            return response()->json(['success' => true], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false], 500);
        }
    }
}
