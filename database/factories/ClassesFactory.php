<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClassesFactory extends Factory
{
    public function definition(): array
    {
        return [
            'class_name' => fake()->unique()->bothify('CLASS-####'),
            'fees' => fake()->numberBetween(500, 5000),
        ];
    }
}