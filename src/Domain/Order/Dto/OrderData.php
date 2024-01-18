<?php

namespace Inventory\Order\Dto;

use App\Models\Order;
use Spatie\LaravelData\Data;
use Inventory\Order\Enums\OrderStatus;
use Inventory\Product\Dto\ProductData;

class OrderData extends Data
{
    public function __construct(
        public ?int $id,
        public string $transaction_session_no,
        public ProductData $product,
        public ?string $product_name,
        public ?string $product_description,
        public float $selling_price,
        public ?int $qty,
        public ?float $subtotal,
        public OrderStatus $status,
    ) {
    }

    public static function fromModel(Order $order)
    {
        return new static(
            $order->id,
            $order->transaction_session_no,
            ProductData::from($order->product),
            $order->product_name,
            $order->product_description,
            $order->selling_price,
            $order->qty,
            $order->subtotal,
            OrderStatus::PENDING
        );
    }
}
