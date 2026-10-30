<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\IncomeSource;
use Illuminate\Database\Eloquent\Factories\Factory;

class IncomeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'source_id' => IncomeSource::factory(),
            'income_amount' => fake()->numberBetween(500, 10000),
            'income_date' => fake()->date(),
            'student_id' => Student::factory(),
        ];
    }
}