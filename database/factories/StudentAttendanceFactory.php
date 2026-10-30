<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentAttendanceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'absent_date' => fake()->date(),
            'absent_type' => fake()->numberBetween(0, 2),
        ];
    }
}