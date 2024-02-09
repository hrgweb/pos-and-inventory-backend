<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Product;
use Illuminate\Console\Command;
use Inventory\Product\Services\ProductService;
use Laravel\Socialite\Facades\Socialite;

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
        $arr = ['tanduay', 'ginamos', 'tanduay'];

        dd(in_array('ginamoss', $arr));
    }
}
