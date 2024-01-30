<?php

namespace Inventory\Sale\Dto;

use Spatie\LaravelData\Data;
use Inventory\Order\Dto\OrderData;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Attributes\DataCollectionOf;

class SaleData extends Data
{
    public function __construct(
        public string $transaction_session_no,
        #[DataCollectionOf(OrderData::class)]
        public DataCollection $orders,
        public float $grand_total,
        public float $amount,
        public ?float $change,
        public ?float $selling_price,
        public ?int $qty,
        public ?int $subtotal,
        public ?array $product_count_occurences
    ) {
    }
}
