<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_salary', function (Blueprint $table) {
            $table->unsignedInteger('staff_id');
            $table->integer('salary_year');
            $table->integer('salary_month');

            $table->integer('absent_amount')->default(0);
            $table->integer('bonus')->default(0);
            $table->integer('tax_amount')->default(0);
            $table->integer('payable_salary');
            $table->float('guarantee');
            $table->integer('net_salary');
            $table->date('pay_date')->nullable();

            $table->primary([
                'staff_id',
                'salary_year',
                'salary_month',
            ]);

            $table->foreign('staff_id', 'staff_staff_salary_fk')
                ->references('staff_id')
                ->on('staff')
                ->onDelete('no action')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_salary');
    }
};