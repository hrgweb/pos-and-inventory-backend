<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Inventory\Product\Dto\ProductData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_of_products(): void
    {
        Product::factory(2)->create();

        $response = $this->getJson(route('products.index'))->assertOk();

        $this->assertEquals(2, count($response['data']));
    }

    public function test_find_a_product():void
    {
        $product = Product::factory()->create(['name' => 'tanduay']);

        $response = $this->getJson(route('products.show', $product->id))->assertOk();

        $this->assertEquals($product->name, $response['name']);
    }

    public function test_create_a_product(): void
    {
        $productData = Product::factory()->make()->toArray();

        $response = $this->postJson(route('products.store'), $productData)
            ->assertCreated();

        $this->assertEquals($productData['name'], $response['name']);
    }

    public function test_update_a_product(): void
    {
        $product = ProductData::from(Product::factory()->create());

        $data = array_merge($product->toArray(), [
            'name' => 'hergen test',
            'description' => 'just a sample testing!',
            'selling_price' => 12.0,
            'stock_qty' => 3,
            'reorder_level' => 4,
            'is_available' => true
        ]);

        $this->putJson("api/products/{$data['id']}", $data)
            ->assertStatus(201)
            ->assertJson(['success' => true]);

        $lastProduct = ProductData::from(Product::latest()->first())?->toArray();

        $this->assertEquals($lastProduct, $data);
    }

    public function test_remove_a_product(): void
    {
        $product = Product::factory()->create();

        $this->deleteJson("/api/products/{$product['id']}")
            ->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    // public function test_user_must_be_authenticated(): void
    // {
    //     $user = User::factory()->create();

    //     Sanctum::actingAs($user);

    //     $this->get('/login')
    //         ->assertOk();
    // }
}
