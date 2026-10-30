<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentTransferFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'transfer_date' => fake()->date(),
            'transfer_no' => fake()->unique()->numerify('TR-######'),
            'school_name' => fake()->company(),
            'transfer_type' => fake()->boolean(),
        ];
    }
}