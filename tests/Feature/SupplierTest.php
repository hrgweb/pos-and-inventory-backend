<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupplierTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_a_supplier(): void
    {
        $data = Supplier::factory()->make()->toArray();

        $response = $this->postJson(route('suppliers.store'), $data)
            ->assertCreated();

        $this->assertEquals($data['name'], $response['name']);
    }
}
