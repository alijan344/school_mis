<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SubjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'subject_name' => fake()->unique()->randomElement([
                'Mathematics',
                'English',
                'Computer Science',
                'Physics',
                'Chemistry',
                'Biology',
                'History',
                'Geography',
            ]) . ' ' . fake()->unique()->numberBetween(1, 9999),
        ];
    }
}