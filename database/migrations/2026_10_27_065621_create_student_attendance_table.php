<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_attendance', function (Blueprint $table) {
            $table->unsignedInteger('student_id');
            $table->date('absent_date');
            $table->tinyInteger('absent_type');

            $table->primary(['student_id', 'absent_date']);

            $table->foreign('student_id', 'student_student_attendance_fk')
                ->references('student_id')
                ->on('student')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_attendance');
    }
};