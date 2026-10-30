<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentDocumentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'document_name' => fake()->word(),
            'document_file' => fake()->uuid() . '.pdf',
            'upload_date' => fake()->date(),
        ];
    }
}