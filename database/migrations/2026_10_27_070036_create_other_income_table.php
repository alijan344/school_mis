<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('other_income', function (Blueprint $table) {
            $table->increments('income_id');

            $table->unsignedInteger('source_id');
            $table->integer('income_amount');
            $table->date('income_date');

            $table->primary(['income_id', 'source_id']);

            $table->foreign('source_id', 'income_source_other_income_fk')
                ->references('source_id')
                ->on('income_source')
                ->onDelete('no action')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('other_income');
    }
};