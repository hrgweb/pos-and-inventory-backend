<?php

namespace Inventory\Product\Services;

use Exception;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
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

        if ($id > 0) {
            $update = Product::where('id', $id)->update($this->request);

            if ($update) {
                return ProductData::from($this->request);
            }
        }

        return ProductData::from(Product::create($this->request));
    }

    public function remove()
    {
        return Product::destroy($this->request['id']);
    }

    public function lookup()
    {
        $search = "{$this->request['search']}%";

        return Product::query()
            ->whereRaw('name like ?', [$search])
            ->OrWhereRaw('barcode like ?', [$search])
            ->get();
    }
}
