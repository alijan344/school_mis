<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserLevelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'staff_id' => User::factory(),
            'admin_level' => 0,
            'academic_level' => 0,
            'student_level' => 0,
            'teacher_level' => 0,
            'staff_level' => 0,
            'finance_level' => 0,
            'library_level' => 0,
            'stock_level' => 0,
            'IT_level' => 0,
        ];
    }
}