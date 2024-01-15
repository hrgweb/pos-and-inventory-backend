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
        ])->save();

        $this->assertDatabaseCount('products', 1);
    }
}
