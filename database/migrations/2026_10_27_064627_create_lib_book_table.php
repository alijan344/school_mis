<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lib_book', function (Blueprint $table) {
            $table->increments('book_id');

            $table->string('isbn', 32)->nullable();
            $table->string('book_name', 128);
            $table->string('author', 64)->nullable();
            $table->integer('publish_year')->nullable();
            $table->string('publisher', 64)->nullable();
            $table->string('shelf', 32);
            $table->string('shelf_row', 32);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lib_book');
    }
};