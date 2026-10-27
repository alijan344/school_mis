<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->increments('staff_id');

            $table->string('firstname', 32);
            $table->string('lastname', 32);
            $table->string('fathername', 32);

            $table->boolean('gender');
            $table->integer('birth_year');

            $table->string('photo', 128);
            $table->string('nic', 64);

            $table->char('phone', 10)->unique();
            $table->string('email', 128)->unique();

            $table->string('province', 64);
            $table->string('district', 64);
            $table->string('village', 64);
            $table->string('current_address', 128);

            $table->string('position', 64);
            $table->integer('gross_salary');

            $table->boolean('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};