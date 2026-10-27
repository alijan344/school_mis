<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_in', function (Blueprint $table) {
            $table->increments('stock_in_id');

            $table->unsignedInteger('stock_id');
            $table->date('in_date');
            $table->float('in_quantity');
            $table->text('remark')->nullable();

            $table->foreign('stock_id', 'stock_stock_in_fk')
                ->references('stock_id')
                ->on('stock')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_in');
    }
};