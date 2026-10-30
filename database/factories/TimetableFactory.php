<?php

namespace Database\Factories;

use App\Models\Teacher;
use App\Models\Subject;
use App\Models\ClassSection;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimetableFactory extends Factory
{
    public function definition(): array
    {
        return [
            'weekday' => fake()->numberBetween(1, 7),
            'lesson_hour' => fake()->numberBetween(1, 8),
            'teacher_id' => Teacher::factory(),
            'subject_id' => Subject::factory(),
            'section_id' => ClassSection::factory(),
        ];
    }
}