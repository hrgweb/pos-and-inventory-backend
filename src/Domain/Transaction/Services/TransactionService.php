<?php

namespace Inventory\Transaction\Services;

use Exception;
use App\Models\Order;
use App\Models\TransactionSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inventory\Order\Enums\OrderStatus;

class TransactionService
{
    public function __construct(protected array $request = [])
    {
    }

    public static function make(...$params)
    {
        return new static(...$params);
    }

    // public static function data(): array
    // {
    //     return [
    //         'products' => ProductData::collection(Product::orderBy('name', 'asc')->get())
    //     ];
    // }

    // public static function fetch()
    // {
    //     return TransactionData::collection(Transaction::with(['product'])->paginate(10));
    // }

    private function purchase()
    {
        // $this->request['product']['barcode'] = BarcodeService::create();

        $product = new Product;
        $transaction = new Transaction;

        DB::beginTransaction();
        try {
            $productId = $this->request['product']['id'];

            $transaction = Transaction::create(array_merge($this->request, ['product_id' => $productId]));

            if (!$transaction) {
                throw new Exception('no inventory transaction saved. encountered an error');
            }

            Log::info('1 inventory transaction saved.');

            // get the stock_qty of the product
            $productStockQty = (int)Product::findOrFail($productId)?->stock_qty;

            // then add it based on the transaction qty
            $updateStockQty = Product::where('id', $productId)->update(['stock_qty' => $productStockQty + $this->request['qty']]);

            if (!$updateStockQty) {
                throw new Exception('updating the stock qty of the product ' . $this->request['product']['name'] . ' was encountered an error.');
            }

            // $product = ProductService::make($this->request['product'])->save();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
        DB::commit();

        // generate barcode img
        // BarcodeService::generate($product->name, $product->barcode);

        return TransactionData::from(array_merge($transaction->toArray(), ['product' => $this->request['product']]))->additional(['created_at' => $transaction->created_at]);
    }

    public function save()
    {
        $transaction_type = $this->request['transaction_type'] ??= TransactionType::PURCHASE;

        return match ($transaction_type) {
            TransactionType::PURCHASE->value => $this->purchase(),
            TransactionType::SALE->value => 'sale',
            TransactionType::ADJUSTMENTS->value => 'adjustment'
        };
    }

    public function update(int $id) //: bool
    {
        DB::beginTransaction();
        try {
            $productId = $this->request['product']['id'];

            $updateTransaction = Transaction::where('id', $id)->update([
                'product_id' => $this->request['product']['id'],
                'transaction_type' => $this->request['transaction_type'],
                'qty' => $this->request['qty'],
                // 'cost_price' => $this->request['cost_price'],
                // 'selling_price' => $this->request['selling_price'],
                // 'subtotal' => $this->request['subtotal'],
                'notes' => $this->request['notes']
            ]);

            if (!$updateTransaction) {
                throw new Exception('no transaction updated. encountered an error.');
            }

            Log::info('transaction (' . $this->request['product']['name'] . ') was successfuly updated.');

            // get the stock_qty of the product
            $productStockQty = (int)Product::findOrFail($productId)?->stock_qty;

            // then add it based on the transaction qty
            $updateStockQty = Product::where('id', $productId)->update(['stock_qty' => $productStockQty + $this->request['qty']]);

            if (!$updateStockQty) {
                throw new Exception('updating the stock qty of the product ' . $this->request['product']['name'] . ' was encountered an error.');
            }
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
        DB::commit();

        return true;
    }

    public function remove(int $id) //: bool
    {
        $remove = Transaction::where('id', $id)->delete();

        if (!$remove) {
            throw new Exception('no transaction was removed. encountered an error.');
        }

        Log::info('1 transaction ' . $this->request['name'] . ' was successfuly removed.');

        return true;
    }

    public function void(): bool
    {
        $transactionSessionNo = $this->request['transaction_session_no'];

        DB::beginTransaction();
        try {
            // update transaction session status to void
            TransactionSession::where('session_no', $transactionSessionNo)->update(['status' => OrderStatus::VOID]);

            // update orders status to void
            Order::where('transaction_session_no', $transactionSessionNo)->update(['status' => OrderStatus::VOID]);
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        DB::commit();

        // dd('3');

        info('transaction session ' . $transactionSessionNo . ' was void.');

        return true;
    }
}
