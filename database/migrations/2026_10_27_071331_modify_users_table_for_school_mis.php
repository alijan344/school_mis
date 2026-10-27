<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // مرحله اول: حذف ویژگی AUTO_INCREMENT از ستون id
        // تا بتوانیم کلید اصلی را به‌صورت امن حذف کنیم.
        DB::statement(
            'ALTER TABLE `users` MODIFY `id` BIGINT UNSIGNED NOT NULL'
        );

        // مرحله دوم: حذف کلید اصلی پیش‌فرض Laravel
        Schema::table('users', function (Blueprint $table) {
            $table->dropPrimary();
        });

        // مرحله سوم: حذف ستون‌های پیش‌فرض غیرضروری Laravel
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'id',
                'name',
                'email',
                'email_verified_at',
                'remember_token',
                'created_at',
                'updated_at',
            ]);
        });

        // مرحله چهارم: ایجاد ستون‌های موردنیاز School MIS
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('staff_id')->primary();
            $table->string('username', 64)->unique();
        });

        // مرحله پنجم: ایجاد ارتباط با جدول staff
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('staff_id', 'staff_users_fk')
                ->references('staff_id')
                ->on('staff')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('staff_users_fk');
            $table->dropUnique('users_username_unique');
            $table->dropPrimary();
            $table->dropColumn([
                'staff_id',
                'username',
            ]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }
};