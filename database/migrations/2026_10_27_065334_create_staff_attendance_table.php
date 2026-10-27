<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_attendance', function (Blueprint $table) {
            $table->unsignedInteger('staff_id');
            $table->integer('absent_year');
            $table->tinyInteger('absent_month');
            $table->tinyInteger('absent_day');
            $table->text('remark')->nullable();

            $table->primary([
                'staff_id',
                'absent_year',
                'absent_month',
                'absent_day',
            ]);

            $table->foreign('staff_id', 'staff_staff_attendance_fk')
                ->references('staff_id')
                ->on('staff')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_attendance');
    }
};