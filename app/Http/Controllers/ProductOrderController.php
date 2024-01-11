<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Hrgweb\SalesAndInventory\Domain\InventoryTransaction\Services\ProductService;
use Hrgweb\SalesAndInventory\Domain\Order\Data\OrderData;
use Hrgweb\SalesAndInventory\Domain\Order\Services\OrderService;

class ProductOrderController extends Controller
{
    public function viaSearchOrBarcode(Request $request)
    {
        try {
            $product = ProductService::make()->search($request->input('query'));

            if (!$product) {
                return response()->json(0, 404);
            }

            $order = OrderService::make([
                'order_transaction_session' => $request->input('transaction_session'),
                'customer_id' => 1,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_description' => $product->description,
                'qty' => 1,
                'selling_price' => $product->selling_price
            ])->save();

            return OrderData::from($order);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }
}
