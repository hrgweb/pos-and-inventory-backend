<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'selling_price' => fake()->numberBetween(90, 200),
            'stock_qty' => fake()->numberBetween(20, 70),
            'reorder_level' => fake()->numberBetween(20, 70),
            'is_available' => fake()->randomElement([true, false]),
        ];
    }
}
