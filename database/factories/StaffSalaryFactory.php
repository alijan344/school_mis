<?php

namespace Database\Factories;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffSalaryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'staff_id' => Staff::factory(),
            'salary_year' => fake()->numberBetween(2024, 2026),
            'salary_month' => fake()->numberBetween(1, 12),
            'absent_amount' => 0,
            'bonus' => fake()->numberBetween(0, 1000),
            'tax_amount' => 0,
            'payable_salary' => fake()->numberBetween(8000, 20000),
            'guarantee' => 0,
            'net_salary' => fake()->numberBetween(8000, 20000),
            'pay_date' => fake()->optional()->date(),
        ];
    }
}