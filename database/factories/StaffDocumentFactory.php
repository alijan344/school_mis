<?php

namespace Database\Factories;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffDocumentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'staff_id' => Staff::factory(),
            'document_name' => fake()->word(),
            'document_file' => fake()->uuid() . '.pdf',
            'upload_date' => fake()->date(),
        ];
    }
}