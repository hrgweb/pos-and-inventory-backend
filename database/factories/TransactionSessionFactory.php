<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Inventory\Order\Enums\OrderStatus;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionSession>
 */
class TransactionSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'session_no' => fake()->ean8(),
            'grand_total' => 0,
            'amount' => 0,
            'change' => 0,
            'status' => OrderStatus::PENDING
        ];
    }
}
