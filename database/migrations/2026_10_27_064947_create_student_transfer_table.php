<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_transfer', function (Blueprint $table) {
            $table->increments('transfer_id');

            $table->unsignedInteger('student_id');
            $table->date('transfer_date');
            $table->string('transfer_no', 32);
            $table->string('school_name', 128);
            $table->boolean('transfer_type');

            $table->foreign('student_id', 'student_student_transfer_fk')
                ->references('student_id')
                ->on('student')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_transfer');
    }
};