<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Log;
use Hrgweb\SalesAndInventory\Domain\InventoryTransaction\Data\InventoryTransactionData;
use Hrgweb\SalesAndInventory\Domain\InventoryTransaction\Services\InventoryTransactionService;

class InventoryTransactionController extends Controller
{
    public function purchase(InventoryTransactionData $inventoryTransaction)
    {
        try {
            return InventoryTransactionService::make($inventoryTransaction->toArray())->purchase();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json($e->getMessage(), 500);
        }
    }

    public function sale()
    {
        return 'sale';
    }

    public function adjustments()
    {
        return 'adjustments';
    }
}
