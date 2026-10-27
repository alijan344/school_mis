<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_attendance', function (Blueprint $table) {
            $table->unsignedInteger('teacher_id');
            $table->integer('absent_year');
            $table->tinyInteger('absent_month');
            $table->tinyInteger('absent_day');
            $table->text('remark')->nullable();

            $table->primary([
                'teacher_id',
                'absent_year',
                'absent_month',
                'absent_day',
            ]);

            $table->foreign('teacher_id', 'teacher_teacher_attendance_fk')
                ->references('teacher_id')
                ->on('teacher')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_attendance');
    }
};