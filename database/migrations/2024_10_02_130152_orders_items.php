<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('order_id'); // Reference to the order
            $table->unsignedBigInteger('product_id'); // Reference to the product
            $table->integer('quantity'); // Quantity ordered
            $table->decimal('price', 8, 2); // Price at the time of order
            $table->decimal('total', 8, 2);
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};

