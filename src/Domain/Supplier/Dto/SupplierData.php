<?php

namespace Inventory\Supplier\Dto;

use Spatie\LaravelData\Data;

class SupplierData extends Data
{
    public function __construct(
        public ?int $id,
        public string $name,
        public ?string $description,
        public ?string $address,
        public ?string $phone_no
    ) {
    }
}
