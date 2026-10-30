<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentRelativeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'relative_name' => fake()->name(),
            'relative_phone' => fake()->numerify('07########'),
            'relative_relation' => fake()->randomElement([
                'Father', 'Mother', 'Brother', 'Uncle'
            ]),
        ];
    }
}