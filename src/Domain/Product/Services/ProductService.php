<?php

namespace Inventory\Product\Services;

use App\Models\Product;

class ProductService
{
    public function __construct(private array $request = [])
    {
    }

    public static function make(...$params)
    {
        return new static(...$params);
    }

    public function save()
    {
        return Product::create($this->request);
    }
}
