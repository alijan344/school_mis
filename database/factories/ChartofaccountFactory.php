<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChartofaccountFactory extends Factory
{
    public function definition(): array
    {
        return [
            'account_name' => fake()->unique()->words(2, true),
        ];
    }
}