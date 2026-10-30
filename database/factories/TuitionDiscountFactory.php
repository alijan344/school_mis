<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\ClassSection;
use Illuminate\Database\Eloquent\Factories\Factory;

class TuitionDiscountFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'section_id' => ClassSection::factory(),
            'discount_year' => 2026,
            'discount_amount' => fake()->randomFloat(2, 100, 3000),
            'discount_type' => fake()->boolean(),
        ];
    }
}