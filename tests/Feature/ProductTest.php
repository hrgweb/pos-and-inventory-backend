<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Inventory\Product\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_create_a_new_product(): void
    {
        ProductService::make([
            'name' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'selling_price' => $this->faker->numberBetween(90, 200),
            'stock_qty' => $this->faker->numberBetween(20, 70),
            'reorder_level' => $this->faker->numberBetween(20, 70),
            'is_available' => $this->faker->randomElement([true, false])
        ])->saveOrUpdate();

        $this->assertDatabaseCount('products', 1);
    }

    public function test_update_a_product(): void
    {
        // Save
        $product = ProductService::make([
            'name' => 'hergen',
            'description' => 'sample test',
            'selling_price' => 12,
            'stock_qty' => 5,
            'reorder_level' => 43,
            'is_available' => true,
        ])->saveOrUpdate();

        $data = [
            'id' => $product->id,
            'name' => 'john doe',
            'description' => 'this is just another testing',
            'selling_price' => 92,
            'stock_qty' => 15,
            'reorder_level' => 30,
            'is_available' => false,
        ];

        // Update
        ProductService::make($data)->saveOrUpdate();

        $this->assertDatabaseHas('products', $data);
    }
}
