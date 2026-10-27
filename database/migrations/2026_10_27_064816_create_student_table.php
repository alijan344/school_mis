<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student', function (Blueprint $table) {
            $table->increments('student_id');

            $table->string('reg_no', 32)->nullable()->unique();

            $table->string('firstname', 32);
            $table->string('fathername', 32);
            $table->string('grandfathername', 32);

            $table->boolean('gender');
            $table->integer('birth_year');

            $table->string('province', 32);
            $table->string('district', 64);
            $table->string('current_address', 128);
            $table->string('nic', 128);
            $table->char('phone', 10);
            $table->string('photo', 128);

            $table->tinyInteger('status');

            $table->unsignedInteger('section_id');

            $table->foreign('section_id', 'section_student_fk')
                ->references('section_id')
                ->on('class_section')
                ->onDelete('no action')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student');
    }
};