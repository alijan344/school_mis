<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->increments('class_id');
            $table->string('class_name', 16)->unique();
            $table->integer('fees');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};