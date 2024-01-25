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
        $perPage = 5;
        return ProductData::collection(Product::latest()->paginate($perPage));
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

    public static function deduction(array $products = []): void
    {
        foreach ($products as $product) {
            $product_id = $product['productId'];

            $stock_qty = (int)Product::where('id', $product_id)->first()?->stock_qty;
            $stock_deduction = (int)$product['count'];
            $stock_left = $stock_qty - $stock_deduction;

            $updated = Product::where('id', $product_id)->update(['stock_qty' => $stock_left]);

            if (!$updated) {
                throw new Exception('product deduction encountered an error.');
            }

            info('product ' . $product['name'] . ' successfuly deducted.');
        }
    }
}
