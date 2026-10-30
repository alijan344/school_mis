<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherDocumentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'teacher_id' => Teacher::factory(),
            'document_name' => fake()->word(),
            'document_file' => fake()->uuid() . '.pdf',
            'upload_date' => fake()->date(),
        ];
    }
}