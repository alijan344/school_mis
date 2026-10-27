<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_level', function (Blueprint $table) {
            $table->unsignedInteger('staff_id')->primary();

            $table->tinyInteger('admin_level')->default(0);
            $table->tinyInteger('academic_level')->default(0);
            $table->tinyInteger('student_level')->default(0);
            $table->tinyInteger('teacher_level')->default(0);
            $table->tinyInteger('staff_level')->default(0);
            $table->tinyInteger('finance_level')->default(0);
            $table->tinyInteger('library_level')->default(0);
            $table->tinyInteger('stock_level')->default(0);
            $table->tinyInteger('IT_level')->default(0);

            $table->foreign('staff_id', 'user_level_staff_fk')
                ->references('staff_id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_level');
    }
};