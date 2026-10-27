<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subject', function (Blueprint $table) {
            $table->increments('subject_id');

            $table->string('subject_name', 64);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subject');
    }
};