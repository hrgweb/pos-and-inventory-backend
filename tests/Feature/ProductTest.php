<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inventory\Product\Dto\ProductData;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_list_of_products(): void
    {
        Product::factory(23)->create();

        $this->getJson('api/products')
            ->assertStatus(200);

        Product::factory()->create();

        $this->assertDatabaseCount('products', 24);
    }

    public function test_create_a_product(): void
    {
        $productData = Product::factory()->make();

        $data = $productData->toArray();

        $this->postJson('/api/products', $data)
            ->assertStatus(201);

        Product::factory()->create();

        $this->assertDatabaseCount('products', 2);
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
}
