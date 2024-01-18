<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Order;
use Inventory\Order\Dto\OrderData;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PosTest extends TestCase
{
    use RefreshDatabase;

    public function test_pos_make_an_order(): void
    {
        $order = OrderData::from(Order::factory()->make())->toArray();

        $response = $this->postJson(route('orders.store'), $order)->assertCreated();

        $this->assertEquals($order['product_name'], $response['product_name']);
    }
}