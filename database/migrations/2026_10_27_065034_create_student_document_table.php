<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_document', function (Blueprint $table) {
            $table->increments('document_id');

            $table->unsignedInteger('student_id');
            $table->string('document_name', 128);
            $table->string('document_file', 128);
            $table->date('upload_date');

            $table->foreign('student_id', 'student_student_document_fk')
                ->references('student_id')
                ->on('student')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_document');
    }
};