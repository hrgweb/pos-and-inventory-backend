<?php

namespace Inventory\Sale\Services;

use Exception;
use App\Models\Sale;
use App\Models\Order;
use App\Models\TransactionSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inventory\Order\Enums\OrderStatus;
use Inventory\Product\Services\ProductService;

class SaleService
{
    public function __construct(protected array $request = [])
    {
    }

    public static function make(...$params)
    {
        return new static(...$params);
    }

    public function save()
    {
        $orders = collect($this->request['orders']);
        $ordersCount = $orders->count();
        $transactionSessionNo = $this->request['transaction_session_no'];

        // no orders made
        if ($ordersCount <= 0) {
            return response()->json('please make an order.', 500);
        }

        DB::beginTransaction();
        try {
            $body = array_merge($this->request, ['grand_total' => $this->total()]);

            foreach ($body['orders'] as $order) {
                $order['order_id'] = $order['id'];
                $order['product_id'] = $order['product']['id'];

                // made a sale
                $sale = Sale::create($order);

                if (!$sale) {
                    throw new Exception('record to sale encountered an error');
                }

                // update order status
                Order::where('transaction_session_no', $transactionSessionNo)->update(['status' => OrderStatus::COMPLETED]);

                // update transaction session no
                TransactionSession::where('session_no', $transactionSessionNo)->update([
                    'status' => OrderStatus::COMPLETED,
                    'grand_total' => $body['grand_total'],
                    'amount' => $body['amount'],
                    'change' => $body['change'],
                ]);
            }

            // product deductions
            ProductService::deduction($this->request['product_count_occurences']);
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
        DB::commit();

        Log::info($ordersCount . ' orders was purchased on session no (' . $transactionSessionNo . ').');

        return ['success' => true, 'msg' => 'sales created successfuly'];
    }

    private function total()
    {
        return collect($this->request['orders'])->reduce(fn (?int $carry,  $order) =>  $carry + $order['subtotal'], 0);
    }
}
