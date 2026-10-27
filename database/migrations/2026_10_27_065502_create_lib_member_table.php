<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lib_member', function (Blueprint $table) {
            $table->unsignedInteger('student_id')->primary();
            $table->date('reg_date');

            $table->foreign('student_id', 'student_lib_member_fk')
                ->references('student_id')
                ->on('student')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lib_member');
    }
};