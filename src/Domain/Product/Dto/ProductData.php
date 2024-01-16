<?php

namespace Inventory\Product\Dto;

use Spatie\LaravelData\Data;

class ProductData extends Data
{
    public function __construct(
        public ?int $id,
        public string $name,
        public ?string $description,
        public float $selling_price,
        public ?int $stock_qty,
        public ?int $reorder_level,
        public ?string $barcode,
        public ?bool $is_available,
    ) {
    }
}
