<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_out', function (Blueprint $table) {
            $table->increments('stock_out_id');

            $table->unsignedInteger('stock_id');
            $table->date('out_date');
            $table->float('out_quantity');
            $table->text('remark')->nullable();

            $table->foreign('stock_id', 'stock_stock_out_fk')
                ->references('stock_id')
                ->on('stock')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_out');
    }
};