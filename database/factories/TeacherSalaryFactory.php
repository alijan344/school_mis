<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherSalaryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'teacher_id' => Teacher::factory(),
            'salary_year' => fake()->numberBetween(2024, 2026),
            'salary_month' => fake()->numberBetween(1, 12),
            'tax_amount' => 0,
            'absent_amount' => 0,
            'loan_amount' => 0,
            'non_absent_bonus' => 0,
            'bonus' => fake()->numberBetween(0, 1000),
            'payable_salary' => fake()->numberBetween(10000, 30000),
            'guarantee' => 0,
            'net_salary' => fake()->numberBetween(10000, 30000),
            'pay_date' => fake()->optional()->date(),
        ];
    }
}