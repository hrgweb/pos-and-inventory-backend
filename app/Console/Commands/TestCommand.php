<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Product;
use Illuminate\Console\Command;
use Inventory\Product\Services\ProductService;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // dd( [
        //     'name' => fake()->sentence(),
        //     'description' => fake()->paragraph(),
        //     'selling_price' => fake()->numberBetween(90, 200),
        //     'stock_qty' => fake()->numberBetween(20, 70),
        //     'reorder_level' => fake()->numberBetween(20, 70),
        //     'is_available' => fake()->randomElement([true, false]),
        // ]);

        $product = Product::factory()->create();
        // $user = User::factory()->create();

        // dd($user);
        dd($product);
    }
}
