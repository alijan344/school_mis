<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('score', function (Blueprint $table) {
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('subject_id');
            $table->integer('exam_year');
            $table->unsignedInteger('section_id');

            $table->tinyInteger('mid_exam');
            $table->tinyInteger('final_exam')->nullable();
            $table->tinyInteger('second_chance')->nullable();
            $table->integer('total_mark')->nullable();

            $table->primary([
                'student_id',
                'subject_id',
                'exam_year',
            ]);

            $table->foreign('student_id', 'student_score_fk')
                ->references('student_id')
                ->on('student')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('subject_id', 'subject_score_fk')
                ->references('subject_id')
                ->on('subject')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('section_id', 'class_section_score_fk')
                ->references('section_id')
                ->on('class_section')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('score');
    }
};