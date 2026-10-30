<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class LibMemberFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'reg_date' => fake()->date(),
        ];
    }
}