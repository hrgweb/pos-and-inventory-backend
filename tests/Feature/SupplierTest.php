<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupplierTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_of_suppliers():void
    {
        Supplier::factory(4)->create();

        $response = $this->getJson(route('suppliers.index'))->assertOk();

        $this->assertEquals(4, count($response['data']));
    }

    public function test_create_a_supplier(): void
    {
        $data = Supplier::factory()->make()->toArray();

        $response = $this->postJson(route('suppliers.store'), $data)
            ->assertCreated();

        $this->assertEquals($data['name'], $response['name']);
    }

    public function test_update_a_supplier(): void
    {
        $data = Supplier::factory()->create();

        $this->putJson(route('suppliers.update', $data['id']), [
            'name' => 'updated megasoft',
            'address' => 'updated address'
        ])
            ->assertCreated();

        $this->assertDatabaseHas('suppliers', ['name' => 'updated megasoft']);
    }
}
