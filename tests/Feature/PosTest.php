<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Product;
use App\Models\TransactionSession;
use Inventory\Order\Dto\OrderData;
use Inventory\Order\Enums\OrderStatus;
use Inventory\Order\Services\OrderService;
use Illuminate\Foundation\Testing\WithFaker;
use Inventory\Order\Class\Order as OrderValue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PosTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_fetch_transaction_session_and_orders(): void
    {
        // transaction sessions
        $transaction_session = TransactionSession::factory()->create(['session_no' => '98424233']);

        // orders
        Order::factory(4)->create(['transaction_session_no' => '98424233']);

        $response = $this->getJson(route('data', ['transaction_session_no' => $transaction_session->session_no]))
            ->assertOk();

        $this->assertDatabaseHas('transaction_sessions', ['session_no' => '98424233']);
        $this->assertEquals(4, count($response['orders']));
    }

    public function test_pos_make_an_order(): void
    {
        $product = Product::factory()->create(['name' => 'ginamos', 'stock_qty' => 1]);

        $order = OrderData::from([
            'transaction_session_no' => '9834928394',
            'product' => $product,
            'selling_price' => 15,
            'status' => OrderStatus::PENDING
        ])->toArray();

        $response = $this->postJson(route('orders.store'), $order);

        if (!$response['success']) {
            $response->assertJson([
                "success" => false,
                "message" => "Ginamos is not available."
            ]);
        }

        // dd($response->json());

        // $this->assertEquals($order['product']['name'], $response['name']);
        $response->assertJson(['success' => true]);
    }

    public function test_pos_make_an_order_but_not_available(): void
    {
        // $product = Product::factory()->create(['name' => 'tanduay', 'stock_qty' => 0]);

        // $this->postJson(route('orders.store'));

        // // Product is not available
        // if (!$product['stock_qty']) {
        //     // $this->assert
        // }

        // $this->assertDatabaseHas('products', [
        //     'name' => 'tanduay',
        //     'stock_qty' => 0
        // ]);


        // dd($order);
    }

    public function test_pos_void_a_transaction()
    {
        $transaction_session = TransactionSession::factory()->create(['session_no' => '98424233']);
        Order::factory(4)->create(['transaction_session_no' => '98424233']);

        $this->postJson(route('transactions.void'), [
            'transaction_session_no' => $transaction_session->session_no
        ])
            ->assertCreated();

        $this->assertDatabaseHas('transaction_sessions', ['session_no' => '98424233', 'status' => OrderStatus::VOID]);
    }

    public function test_make_a_sale(): void
    {
        Product::factory()->create(['name' => 'tanduay', 'stock_qty' => 3]);
        Product::factory()->create(['name' => 'ginamos', 'stock_qty' => 7]);
        Product::factory()->create(['name' => 'alfonso', 'stock_qty' => 5]);

        // dd(Product::all()->toArray());

        $item = Product::findOrFail(1); //tanduay
        $item2 = Product::findOrFail(2); //ginamos;
        $item3 = $item2;
        $item4 = Product::findOrFail(3);
        $item5 = $item4;
        $item6 = $item4;

        $items = [];
        array_push($items, $item, $item2, $item3, $item4, $item5, $item6);

        // dd($items);

        Order::create(array_merge($item->toArray(), ['transaction_session_no' => '40006215', 'product_id' => $item->id]));
        Order::create(array_merge($item2->toArray(), ['transaction_session_no' => '40006215', 'product_id' => $item2->id]));
        Order::create(array_merge($item3->toArray(), ['transaction_session_no' => '40006215', 'product_id' => $item3->id]));
        Order::create(array_merge($item3->toArray(), ['transaction_session_no' => '40006215', 'product_id' => $item4->id]));
        Order::create(array_merge($item3->toArray(), ['transaction_session_no' => '40006215', 'product_id' => $item5->id]));
        Order::create(array_merge($item3->toArray(), ['transaction_session_no' => '40006215', 'product_id' => $item6->id]));

        // dd(Order::all()->toArray());

        $this->assertDatabaseCount('products', 3);
        $this->assertDatabaseCount('orders', 6);

        $orders = Order::all();

        $data = [
            'transaction_session_no' => '869574',
            'orders' => OrderData::collection($orders)->toArray(),
            'grand_total' => OrderService::grandTotal($orders),
            'amount' => 1000, // customer money
            'product_count_occurences' => OrderValue::getQtyOfEachProducts($orders->toArray())
        ];

        // dd(OrderService::grandTotal($orders));
        // dd($data);

        $this->postJson(route('sales.store'), $data)->assertCreated()
            ->assertJson(['success' => true]);

        $this->assertDatabaseCount('sales', 6)
            ->assertDatabaseHas('sales', ['transaction_session_no' => '40006215']);

        // products left
        $tanduay = Product::where('name', 'tanduay')->firstOrFail()?->stock_qty;
        $this->assertEquals(2, $tanduay);

        $ginamos = Product::where('name', 'ginamos')->firstOrFail()?->stock_qty;
        $this->assertEquals(5, $ginamos);

        $alfonso = Product::where('name', 'alfonso')->firstOrFail()?->stock_qty;
        $this->assertEquals(2, $alfonso);

        // dd(Product::all()->toArray());

    }
}
