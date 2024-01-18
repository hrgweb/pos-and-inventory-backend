<?php

namespace Inventory\Order\Services;

use Exception;
use App\Models\Order;
use App\Models\Product;
use Inventory\Order\Dto\OrderData;
use Illuminate\Support\Facades\Log;

class OrderService
{
    public function __construct(private array $request = [])
    {
    }

    public static function make(...$params)
    {
        return new static(...$params);
    }

    public static function fetch($transactionSessionNo = ''): mixed
    {
        return OrderData::collection(Order::where('transaction_session_no', $transactionSessionNo)->get());
    }

    public function save(): OrderData
    {
        $product = $this->request['product'];

        // get the remaining stock qty of the product
        $productStockQty = (int)Product::find($product['id'])?->stock_qty;

        // check the stock qty is empty
        if ($productStockQty <= 0) {
            $msg = ucfirst($product['name']) . ' is not available.';
            return response()->json([
                'errors' => [$msg],
                'message' => $msg
            ], 404);
        }

        // the product has stocks left

        $body = array_merge($this->request, [
            'product_id' => $product['id'],
            'product_name' => $product['name'],
            'product_description' => $product['description'],
        ]);

        $order = Order::create($body);

        if (!$order) {
            throw new Exception('no order saved. encountered an error.');
        }

        Log::info('1 order saved.');

        return OrderData::from($order);
    }
}
