<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('income', function (Blueprint $table) {
            $table->increments('income_id');

            $table->unsignedInteger('source_id');
            $table->integer('income_amount');
            $table->date('income_date');
            $table->unsignedInteger('student_id');

            $table->foreign('source_id', 'income_source_income_fk')
                ->references('source_id')
                ->on('income_source')
                ->onDelete('no action')
                ->onUpdate('cascade');

            $table->foreign('student_id', 'student_income_fk')
                ->references('student_id')
                ->on('student')
                ->onDelete('no action')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('income');
    }
};