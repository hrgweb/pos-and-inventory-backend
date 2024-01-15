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

    public function saveOrUpdate()
    {
        $id = $this->request['id'] ??= 0;

        if ($id <= 0) {
            return Product::create($this->request);
        }

        return Product::where('id', $id)->update($this->request);
    }
}
