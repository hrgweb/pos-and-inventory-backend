<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Inventory\Product\Dto\ProductData;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_of_products(): void
    {
        Product::factory(2)->create();

        $response = $this->getJson(route('products.index'))->assertOk();

        $this->assertEquals(2, count($response['data']));
    }

    public function test_find_a_product(): void
    {
        $product = Product::factory()->create(['name' => 'tanduay']);

        $response = $this->getJson(route('products.show', $product->id))->assertOk();

        $this->assertEquals($product->name, $response['name']);
    }

    public function test_create_a_product(): void
    {
        $productData = Product::factory()->make()->toArray();
        // $productData = ['name' => 'hrg', 'selling_price' => 3, 'stock_qty' => 11, 'reorder_level' => 18, 'is_available' => true];

        $response = $this->postJson(route('products.store'), $productData)
            ->assertCreated();

        $this->assertEquals($productData['name'], $response['name']);
    }

    public function test_update_a_product(): void
    {
        $product = ProductData::from(Product::factory()->create());

        $this->putJson(route('products.update', $product->id), ['product' => $product->id, 'name' => 'updated name', 'description' => 'updated description'])
            ->assertCreated()
            ->assertJson(['description' => 'updated description']);

        $this->assertDatabaseHas('products', ['description' => 'updated description']);
    }

    public function test_remove_a_product(): void
    {
        $product = Product::factory()->create();

        $this->deleteJson(route('products.destroy', $product['id']))
            ->assertNoContent();

        $this->assertDatabaseMissing('products', ['name' => $product->name]);
    }

    // public function test_user_must_be_authenticated(): void
    // {
    //     $user = User::factory()->create();

    //     Sanctum::actingAs($user);

    //     $this->get('/login')
    //         ->assertOk();
    // }
}
