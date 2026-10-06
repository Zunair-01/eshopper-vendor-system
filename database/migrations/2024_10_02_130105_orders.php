<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('user_id'); // Reference to the user placing the order
            $table->decimal('subtotal', 8, 2); // Subtotal for the items in the order
            $table->decimal('grand_total', 8, 2); // Grand total after any additional charges (like taxes, shipping, etc.)
            $table->string('status')->default('pending'); // Order status
            $table->timestamps();

            // Foreign key linking to users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
