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
        Schema::create('transaction_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_no')->index();
            $table->decimal('grand_total', 15, 2)->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->decimal('change', 15, 2)->nullable();
            $table->string('status')->default('pending');    // eg. pending, completed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_sessions');
    }
};
