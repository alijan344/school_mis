<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timetable', function (Blueprint $table) {
            $table->tinyInteger('weekday');
            $table->tinyInteger('lesson_hour');

            $table->unsignedInteger('teacher_id');
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('section_id');

            $table->primary([
                'weekday',
                'lesson_hour',
                'teacher_id',
            ]);

            $table->foreign('teacher_id', 'teacher_timetable_fk')
                ->references('teacher_id')
                ->on('teacher')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('subject_id', 'subject_timetable_fk')
                ->references('subject_id')
                ->on('subject')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('section_id', 'class_section_timetable_fk')
                ->references('section_id')
                ->on('class_section')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timetable');
    }
};