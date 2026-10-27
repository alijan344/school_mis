<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tuition_discount', function (Blueprint $table) {
            $table->unsignedInteger('student_id');
            $table->integer('discount_year');
            $table->unsignedInteger('section_id');

            $table->float('discount_amount');
            $table->boolean('discount_type');

            $table->primary([
                'student_id',
                'discount_year',
            ]);

            $table->foreign('student_id', 'student_tuition_discount_fk')
                ->references('student_id')
                ->on('student')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('section_id', 'class_section_tuition_discount_fk')
                ->references('section_id')
                ->on('class_section')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tuition_discount');
    }
};