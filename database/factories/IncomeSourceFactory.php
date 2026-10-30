<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class IncomeSourceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'source_name' => fake()->unique()->words(2, true),
        ];
    }
}