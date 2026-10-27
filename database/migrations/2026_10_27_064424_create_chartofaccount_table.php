<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chartofaccount', function (Blueprint $table) {
            $table->increments('account_id');
            $table->string('account_name', 64)->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chartofaccount');
    }
};