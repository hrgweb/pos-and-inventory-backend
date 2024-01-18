<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::factory()->create();
        $sellingPrice = fake()->numberBetween(50, 500);
        $qty = fake()->numberBetween(1, 100);

        return [
            'transaction_session_no' => fake()->ean8(),
            'product_id' => fn () => $product->id,
            'product_name' => $product->name,
            'product_description' => $product->description,
            'selling_price' => $sellingPrice ?? 0,
            'qty' => $qty ?? 0,
            'subtotal' => $sellingPrice * $qty
        ];
    }
}
