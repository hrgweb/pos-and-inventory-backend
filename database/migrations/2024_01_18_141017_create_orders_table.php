<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_session_no')->index();

            $table->unsignedBigInteger('product_id')->index();
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();

            // Products
            $table->string('product_name')->nullable()->index();
            $table->text('product_description')->nullable();
            $table->decimal('selling_price', 15, 2);
            $table->integer('qty')->nullable();
            $table->decimal('subtotal', 15, 2)->nullable();

            $table->enum('status', ['pending', 'completed', 'void'])->nullable();   // (e.g., pending, completed, void).
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
