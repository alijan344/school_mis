<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_document', function (Blueprint $table) {
            $table->increments('document_id');

            $table->unsignedInteger('staff_id');
            $table->string('document_name', 64);
            $table->string('document_file', 128);
            $table->date('upload_date');

            $table->foreign('staff_id', 'staff_staff_document_fk')
                ->references('staff_id')
                ->on('staff')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_document');
    }
};