<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Student indexes

        if (!Schema::hasIndex('student', 'student_status_index')) {
            Schema::table('student', function (Blueprint $table) {
                $table->index('status', 'student_status_index');
            });
        }

        if (!Schema::hasIndex('student', 'student_birth_year_index')) {
            Schema::table('student', function (Blueprint $table) {
                $table->index('birth_year', 'student_birth_year_index');
            });
        }

        // Teacher indexes

        if (!Schema::hasIndex('teacher', 'teacher_status_index')) {
            Schema::table('teacher', function (Blueprint $table) {
                $table->index('status', 'teacher_status_index');
            });
        }

        if (!Schema::hasIndex('teacher', 'teacher_birth_year_index')) {
            Schema::table('teacher', function (Blueprint $table) {
                $table->index('birth_year', 'teacher_birth_year_index');
            });
        }

        // Staff indexes

        if (!Schema::hasIndex('staff', 'staff_status_index')) {
            Schema::table('staff', function (Blueprint $table) {
                $table->index('status', 'staff_status_index');
            });
        }

        if (!Schema::hasIndex('staff', 'staff_position_index')) {
            Schema::table('staff', function (Blueprint $table) {
                $table->index('position', 'staff_position_index');
            });
        }
    }

    public function down(): void
    {
        // Remove only indexes created by this migration.

        if (Schema::hasIndex('student', 'student_status_index')) {
            Schema::table('student', function (Blueprint $table) {
                $table->dropIndex('student_status_index');
            });
        }

        if (Schema::hasIndex('student', 'student_birth_year_index')) {
            Schema::table('student', function (Blueprint $table) {
                $table->dropIndex('student_birth_year_index');
            });
        }

        if (Schema::hasIndex('teacher', 'teacher_status_index')) {
            Schema::table('teacher', function (Blueprint $table) {
                $table->dropIndex('teacher_status_index');
            });
        }

        if (Schema::hasIndex('teacher', 'teacher_birth_year_index')) {
            Schema::table('teacher', function (Blueprint $table) {
                $table->dropIndex('teacher_birth_year_index');
            });
        }

        if (Schema::hasIndex('staff', 'staff_status_index')) {
            Schema::table('staff', function (Blueprint $table) {
                $table->dropIndex('staff_status_index');
            });
        }

        if (Schema::hasIndex('staff', 'staff_position_index')) {
            Schema::table('staff', function (Blueprint $table) {
                $table->dropIndex('staff_position_index');
            });
        }
    }
};