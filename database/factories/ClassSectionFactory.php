<?php

namespace Database\Factories;

use App\Models\Classes;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassSectionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'section_name' => fake()->unique()->bothify('SECTION-####'),
            'class_id' => Classes::factory(),
        ];
    }
}