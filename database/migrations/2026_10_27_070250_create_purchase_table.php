<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase', function (Blueprint $table) {
            $table->increments('purchase_id');

            $table->unsignedInteger('staff_id')->nullable();
            $table->date('purchase_date');
            $table->string('item_name', 128);
            $table->string('unit', 32);
            $table->float('quantity');
            $table->integer('unitprice');
            $table->integer('totalprice');

            $table->foreign('staff_id', 'staff_purchase_fk')
                ->references('staff_id')
                ->on('staff')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase');
    }
};