<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->decimal('tax', 10, 2); // Adjust the precision as needed
            $table->decimal('discount', 10, 2);
            $table->decimal('delivery_charges', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('charges');
    }
};
