<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_salary', function (Blueprint $table) {
            $table->unsignedInteger('teacher_id');
            $table->integer('salary_year');
            $table->tinyInteger('salary_month');

            $table->integer('tax_amount')->default(0);
            $table->integer('absent_amount')->default(0);
            $table->integer('loan_amount')->default(0);
            $table->integer('non_absent_bonus')->default(0);
            $table->integer('bonus')->default(0);
            $table->integer('payable_salary');
            $table->float('guarantee');
            $table->integer('net_salary');
            $table->date('pay_date')->nullable();

            $table->primary([
                'teacher_id',
                'salary_year',
                'salary_month',
            ]);

            $table->foreign('teacher_id', 'teacher_teacher_salary_fk')
                ->references('teacher_id')
                ->on('teacher')
                ->onDelete('no action')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_salary');
    }
};