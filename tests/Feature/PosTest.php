<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Order;
use App\Models\TransactionSession;
use Inventory\Order\Dto\OrderData;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inventory\Order\Enums\OrderStatus;
use Inventory\Order\Services\OrderService;

class PosTest extends TestCase
{
    use RefreshDatabase;

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
        $order = OrderData::from(Order::factory()->make())->toArray();

        $response = $this->postJson(route('orders.store'), $order)->assertCreated();

        $this->assertEquals($order['product_name'], $response['product_name']);
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
        $orders = Order::factory(4)->create(['transaction_session_no' => '98424233', 'subtotal' => 5]);

        $data = [
            'transaction_session_no' => '869574',
            'orders' => OrderData::collection($orders)->toArray(),
            'grand_total' => OrderService::grandTotal($orders),
            'amount' => 10,
            'product_count_occurences' => []
        ];

        dd($data);

        $response = $this->postJson(route('sales.store'), $data)->assertCreated()
            ->assertJson(['success' => true]);

        $this->assertDatabaseCount('sales', 4);
    }
}
