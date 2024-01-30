<?php

namespace Inventory\Order\Class;

use stdClass;

class Order
{
    private static function uniqueProducts(array $orders): array
    {
        $newOrders = [];
        $uniqueOrders = [];

        foreach ($orders as $order) {
            $product = $order['product'];

            if (!in_array($product['name'], $uniqueOrders)) {
                array_push($uniqueOrders, $product['name']);
                array_push($newOrders, ['id' => $product['id'], 'name' => $product['name']]);
            }
        }

        return $newOrders;
    }

    public static function getQtyOfEachProducts(array $orders): array
    {
        $products = static::uniqueProducts($orders);

        $listOfOrders = [];

        foreach ($products as $product) {

            $newProduct = new stdClass;
            $newProduct->id = $product['id'];
            $newProduct->name = $product['name'];
            $newProduct->qty = 0;

            for ($j = 0; $j < count($orders); $j++) {
                $product2 = $orders[$j]['product'];

                if ($product['id'] === $product2['id']) {
                    $newProduct->qty++;
                    continue;
                }
            }

            array_push($listOfOrders, $newProduct);
        }

        return $listOfOrders;
    }
}
