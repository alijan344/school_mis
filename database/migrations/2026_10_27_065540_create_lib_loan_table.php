<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lib_loan', function (Blueprint $table) {
            $table->increments('loan_id');

            $table->unsignedInteger('student_id');
            $table->unsignedInteger('book_id');
            $table->date('loan_date');
            $table->date('return_date')->nullable();

            $table->foreign('student_id', 'lib_member_lib_loan_fk')
                ->references('student_id')
                ->on('lib_member')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('book_id', 'lib_book_lib_loan_fk')
                ->references('book_id')
                ->on('lib_book')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lib_loan');
    }
};