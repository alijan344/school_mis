<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_relative', function (Blueprint $table) {
            $table->increments('relative_id');

            $table->unsignedInteger('student_id');
            $table->string('relative_name', 64);
            $table->char('relative_phone', 10);
            $table->string('relative_relation', 32);

            $table->foreign('student_id', 'student_student_relative')
                ->references('student_id')
                ->on('student')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_relative');
    }
};