<?php

namespace Tests\Unit;

use stdClass;
use Tests\TestCase;
use App\Models\Order;
use Inventory\Order\Dto\OrderData;
use Inventory\Order\Class\Order as OrderValue;
use Inventory\Order\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_calculate_the_grand_total(): void
    {
        $orders = Order::factory(3)->create(['subtotal' => 5]);

        $this->assertEquals(15, OrderService::grandTotal($orders));
    }

    // public function test_get_the_qty_of_each_product_in_orders(): void
    // {
    //     $orders = [
    //         [
    //             "id" => 1,
    //             "transaction_session_no" => "869574",
    //             "product" => [
    //                 "id" => 1,
    //                 "name" => "tanduay",
    //                 "description" => "habang tumatagal lalong sumasarap",
    //                 "cost_price" => 105,
    //                 "selling_price" => 120,
    //                 "stock_qty" => 45,
    //                 "reorder_level" => 20,
    //                 "barcode" => null,
    //                 "is_available" => true
    //             ],
    //             "product_name" => "tanduay",
    //             "product_description" => "habang tumatagal lalong sumasarap",
    //             "selling_price" => 120,
    //             "qty" => 1,
    //             "subtotal" => 120,
    //             "status" => "pending"
    //         ],
    //         [
    //             "id" => 2,
    //             "transaction_session_no" => "869574",
    //             "product" => [
    //                 "id" => 3,
    //                 "name" => "ginamos",
    //                 "description" => "homemade ginamos",
    //                 "cost_price" => 8,
    //                 "selling_price" => 15,
    //                 "stock_qty" => 15,
    //                 "reorder_level" => 20,
    //                 "barcode" => null,
    //                 "is_available" => true
    //             ],
    //             "product_name" => "ginamos",
    //             "product_description" => "homemade ginamos",
    //             "selling_price" => 15,
    //             "qty" => 1,
    //             "subtotal" => 15,
    //             "status" => "pending"
    //         ],
    //         [
    //             "id" => 3,
    //             "transaction_session_no" => "869574",
    //             "product" => [
    //                 "id" => 3,
    //                 "name" => "ginamos",
    //                 "description" => "homemade ginamos",
    //                 "cost_price" => 8,
    //                 "selling_price" => 15,
    //                 "stock_qty" => 15,
    //                 "reorder_level" => 20,
    //                 "barcode" => null,
    //                 "is_available" => true
    //             ],
    //             "product_name" => "ginamos",
    //             "product_description" => "homemade ginamos",
    //             "selling_price" => 15,
    //             "qty" => 1,
    //             "subtotal" => 15,
    //             "status" => "pending"
    //         ],
    //         [
    //             "id" => 4,
    //             "transaction_session_no" => "869574",
    //             "product" => [
    //                 "id" => 3,
    //                 "name" => "ginamos",
    //                 "description" => "homemade ginamos",
    //                 "cost_price" => 8,
    //                 "selling_price" => 15,
    //                 "stock_qty" => 15,
    //                 "reorder_level" => 20,
    //                 "barcode" => null,
    //                 "is_available" => true
    //             ],
    //             "product_name" => "ginamos",
    //             "product_description" => "homemade ginamos",
    //             "selling_price" => 15,
    //             "qty" => 1,
    //             "subtotal" => 15,
    //             "status" => "pending"
    //         ],
    //         [
    //             "id" => 5,
    //             "transaction_session_no" => "869574",
    //             "product" => [
    //                 "id" => 3,
    //                 "name" => "ginamos",
    //                 "description" => "homemade ginamos",
    //                 "cost_price" => 8,
    //                 "selling_price" => 15,
    //                 "stock_qty" => 15,
    //                 "reorder_level" => 20,
    //                 "barcode" => null,
    //                 "is_available" => true
    //             ],
    //             "product_name" => "ginamos",
    //             "product_description" => "homemade ginamos",
    //             "selling_price" => 15,
    //             "qty" => 1,
    //             "subtotal" => 15,
    //             "status" => "pending"
    //         ],
    //         [
    //             "id" => 6,
    //             "transaction_session_no" => "869574",
    //             "product" => [
    //                 "id" => 4,
    //                 "name" => "alfonso",
    //                 "description" => "the number 1 brandy",
    //                 "cost_price" => 280,
    //                 "selling_price" => 350,
    //                 "stock_qty" => 400,
    //                 "reorder_level" => 350,
    //                 "barcode" => null,
    //                 "is_available" => true
    //             ],
    //             "product_name" => "alfonso",
    //             "product_description" => "the number 1 brandy",
    //             "selling_price" => 350,
    //             "qty" => 1,
    //             "subtotal" => 350,
    //             "status" => "pending"
    //         ],
    //         [
    //             "id" => 7,
    //             "transaction_session_no" => "869574",
    //             "product" => [
    //                 "id" => 4,
    //                 "name" => "alfonso",
    //                 "description" => "the number 1 brandy",
    //                 "cost_price" => 280,
    //                 "selling_price" => 350,
    //                 "stock_qty" => 400,
    //                 "reorder_level" => 350,
    //                 "barcode" => null,
    //                 "is_available" => true
    //             ],
    //             "product_name" => "alfonso",
    //             "product_description" => "the number 1 brandy",
    //             "selling_price" => 350,
    //             "qty" => 1,
    //             "subtotal" => 350,
    //             "status" => "pending"
    //         ],
    //         [
    //             "id" => 1,
    //             "transaction_session_no" => "869574",
    //             "product" => [
    //                 "id" => 1,
    //                 "name" => "tanduay",
    //                 "description" => "habang tumatagal lalong sumasarap",
    //                 "cost_price" => 105,
    //                 "selling_price" => 120,
    //                 "stock_qty" => 45,
    //                 "reorder_level" => 20,
    //                 "barcode" => null,
    //                 "is_available" => true
    //             ],
    //             "product_name" => "tanduay",
    //             "product_description" => "habang tumatagal lalong sumasarap",
    //             "selling_price" => 120,
    //             "qty" => 1,
    //             "subtotal" => 120,
    //             "status" => "pending"
    //         ],
    //     ];

    //     $result = OrderValue::getQtyOfEachProducts($orders);
    //     return $this->assertEquals($result, [

    //     ])
    // }
}
