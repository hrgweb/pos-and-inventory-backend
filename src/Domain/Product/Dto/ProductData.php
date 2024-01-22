<?php

namespace Inventory\Product\Dto;

use Spatie\LaravelData\Data;

class ProductData extends Data
{
    public function __construct(
        public ?int $id,
        public string $name,
        public ?string $description,
        public ?float $cost_price,
        public ?float $selling_price,
        public ?int $stock_qty,
        public ?int $reorder_level,
        public ?string $barcode,
        public ?bool $is_available,
    ) {
        $this->selling_price ??= 0;
        $this->stock_qty ??= 0;
        $this->reorder_level ??= 0;
        $this->is_available ??= true;
    }
}
