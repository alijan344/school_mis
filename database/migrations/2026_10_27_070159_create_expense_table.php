<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expense', function (Blueprint $table) {
            $table->increments('expense_id');

            $table->unsignedInteger('account_id');
            $table->integer('expense_amount');
            $table->date('expense_date');
            $table->text('remark')->nullable();

            $table->foreign('account_id', 'chartofaccount_expense_fk')
                ->references('account_id')
                ->on('chartofaccount')
                ->onDelete('no action')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expense');
    }
};