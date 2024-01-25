<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Product;
use Illuminate\Console\Command;
use Inventory\Product\Services\ProductService;
use Laravel\Socialite\Facades\Socialite;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dd(Socialite::class);


        function unique_multidim_array($array, $key)
        {
            $temp_array = array();
            $i = 0;
            $key_array = array();

            foreach ($array as $val) {
                if (!in_array($val[$key], $key_array)) {
                    $key_array[$i] = $val[$key];
                    $temp_array[$i] = $val;
                }

                $i++;
            }

            return $temp_array;
        }

        $orders = [
            [
                "id" => 1,
                "transaction_session_no" => "869574",
                "product" => [
                    "id" => 1,
                    "name" => "tanduay",
                    "description" => "habang tumatagal lalong sumasarap",
                    "cost_price" => 105,
                    "selling_price" => 120,
                    "stock_qty" => 45,
                    "reorder_level" => 20,
                    "barcode" => null,
                    "is_available" => true
                ],
                "product_name" => "tanduay",
                "product_description" => "habang tumatagal lalong sumasarap",
                "selling_price" => 120,
                "qty" => 1,
                "subtotal" => 120,
                "status" => "pending"
            ],
            [
                "id" => 2,
                "transaction_session_no" => "869574",
                "product" => [
                    "id" => 3,
                    "name" => "ginamos",
                    "description" => "homemade ginamos",
                    "cost_price" => 8,
                    "selling_price" => 15,
                    "stock_qty" => 15,
                    "reorder_level" => 20,
                    "barcode" => null,
                    "is_available" => true
                ],
                "product_name" => "ginamos",
                "product_description" => "homemade ginamos",
                "selling_price" => 15,
                "qty" => 1,
                "subtotal" => 15,
                "status" => "pending"
            ],
            [
                "id" => 3,
                "transaction_session_no" => "869574",
                "product" => [
                    "id" => 3,
                    "name" => "ginamos",
                    "description" => "homemade ginamos",
                    "cost_price" => 8,
                    "selling_price" => 15,
                    "stock_qty" => 15,
                    "reorder_level" => 20,
                    "barcode" => null,
                    "is_available" => true
                ],
                "product_name" => "ginamos",
                "product_description" => "homemade ginamos",
                "selling_price" => 15,
                "qty" => 1,
                "subtotal" => 15,
                "status" => "pending"
            ],
            [
                "id" => 4,
                "transaction_session_no" => "869574",
                "product" => [
                    "id" => 3,
                    "name" => "ginamos",
                    "description" => "homemade ginamos",
                    "cost_price" => 8,
                    "selling_price" => 15,
                    "stock_qty" => 15,
                    "reorder_level" => 20,
                    "barcode" => null,
                    "is_available" => true
                ],
                "product_name" => "ginamos",
                "product_description" => "homemade ginamos",
                "selling_price" => 15,
                "qty" => 1,
                "subtotal" => 15,
                "status" => "pending"
            ],
            [
                "id" => 5,
                "transaction_session_no" => "869574",
                "product" => [
                    "id" => 3,
                    "name" => "ginamos",
                    "description" => "homemade ginamos",
                    "cost_price" => 8,
                    "selling_price" => 15,
                    "stock_qty" => 15,
                    "reorder_level" => 20,
                    "barcode" => null,
                    "is_available" => true
                ],
                "product_name" => "ginamos",
                "product_description" => "homemade ginamos",
                "selling_price" => 15,
                "qty" => 1,
                "subtotal" => 15,
                "status" => "pending"
            ],
            [
                "id" => 6,
                "transaction_session_no" => "869574",
                "product" => [
                    "id" => 4,
                    "name" => "alfonso",
                    "description" => "the number 1 brandy",
                    "cost_price" => 280,
                    "selling_price" => 350,
                    "stock_qty" => 400,
                    "reorder_level" => 350,
                    "barcode" => null,
                    "is_available" => true
                ],
                "product_name" => "alfonso",
                "product_description" => "the number 1 brandy",
                "selling_price" => 350,
                "qty" => 1,
                "subtotal" => 350,
                "status" => "pending"
            ],
            [
                "id" => 7,
                "transaction_session_no" => "869574",
                "product" => [
                    "id" => 4,
                    "name" => "alfonso",
                    "description" => "the number 1 brandy",
                    "cost_price" => 280,
                    "selling_price" => 350,
                    "stock_qty" => 400,
                    "reorder_level" => 350,
                    "barcode" => null,
                    "is_available" => true
                ],
                "product_name" => "alfonso",
                "product_description" => "the number 1 brandy",
                "selling_price" => 350,
                "qty" => 1,
                "subtotal" => 350,
                "status" => "pending"
            ],
            [
                "id" => 1,
                "transaction_session_no" => "869574",
                "product" => [
                    "id" => 1,
                    "name" => "tanduay",
                    "description" => "habang tumatagal lalong sumasarap",
                    "cost_price" => 105,
                    "selling_price" => 120,
                    "stock_qty" => 45,
                    "reorder_level" => 20,
                    "barcode" => null,
                    "is_available" => true
                ],
                "product_name" => "tanduay",
                "product_description" => "habang tumatagal lalong sumasarap",
                "selling_price" => 120,
                "qty" => 1,
                "subtotal" => 120,
                "status" => "pending"
            ],
        ];

        $orders = unique_multidim_array($orders, 'id');

        dd($orders);
    }
}
