<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_document', function (Blueprint $table) {
            $table->increments('document_id');

            $table->unsignedInteger('teacher_id');
            $table->string('document_name', 128);
            $table->string('document_file', 128);
            $table->date('upload_date');

            $table->foreign('teacher_id', 'teacher_teacher_document_fk')
                ->references('teacher_id')
                ->on('teacher')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_document');
    }
};