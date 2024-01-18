<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Order;
use App\Models\TransactionSession;
use Inventory\Order\Dto\OrderData;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inventory\Order\Enums\OrderStatus;

class PosTest extends TestCase
{
    use RefreshDatabase;

    public function test_fetch_transaction_session_orders_and_suppliers(): void
    {
        $transaction_session = TransactionSession::factory()->create(['session_no' => '98424233']);

        $orders = Order::factory(4)->create(['transaction_session_no' => '98424233']);

        $this->getJson(route('data', ['transaction_session_no' => $transaction_session->session_no]))
            ->assertOk();

        $this->assertDatabaseHas('transaction_sessions', ['session_no' => '98424233']);
        $this->assertEquals(4, $orders->count());
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
}
