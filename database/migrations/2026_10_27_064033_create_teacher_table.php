<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher', function (Blueprint $table) {
            $table->increments('teacher_id');

            $table->string('firstname', 32);
            $table->string('lastname', 32);
            $table->string('fathername', 32);

            $table->boolean('gender');
            $table->integer('birth_year');

            $table->string('photo', 128);

            $table->char('phone', 10)->unique();
            $table->string('email', 128)->nullable()->unique();

            $table->string('province', 64);
            $table->string('district', 64);
            $table->string('village', 64);
            $table->string('current_address', 128);

            $table->string('education_degree', 32);
            $table->string('education_field', 32);
            $table->string('education_university', 64);
            $table->integer('education_year');

            $table->integer('talent_score');
            $table->integer('gross_salary');

            $table->integer('hod_bonus')->default(0);
            $table->integer('academic_bonus')->default(0);
            $table->integer('food_charge')->default(0);
            $table->integer('talent_bonus')->default(0);

            $table->boolean('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher');
    }
};