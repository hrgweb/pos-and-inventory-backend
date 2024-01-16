<?php

namespace Inventory\Product\Services;

use Exception;
use App\Models\Product;
use Inventory\Product\Dto\ProductData;

class ProductService
{
    public function __construct(private array $request = [])
    {
    }

    public static function make(...$params)
    {
        return new static(...$params);
    }

    public function list()
    {
        return ProductData::collection(Product::paginate());
    }

    public function saveOrUpdate(): ProductData
    {
        $id = $this->request['id'] ??= 0;

        if (!$id) {
            return ProductData::from(Product::create($this->request));
        }

        $update = Product::where('id', $id)->update($this->request);

        if ($update) {
            return ProductData::from($this->request);
        }
    }

    public function remove()
    {
        Product::where('id', $this->request['id'])->delete();
    }
}
