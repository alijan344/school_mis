<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_section', function (Blueprint $table) {
            $table->increments('section_id');

            $table->string('section_name', 32)->unique();

            $table->unsignedInteger('class_id');

            $table->foreign('class_id', 'classes_class_section_fk')
                ->references('class_id')
                ->on('classes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_section');
    }
};