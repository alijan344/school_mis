<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock', function (Blueprint $table) {
            $table->increments('stock_id');
            $table->string('item_name', 32);
            $table->string('unit', 32);
            $table->float('quantity');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock');
    }
};