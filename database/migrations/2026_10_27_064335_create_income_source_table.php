<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('income_source', function (Blueprint $table) {
            $table->increments('source_id');
            $table->string('source_name', 64);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('income_source');
    }
};