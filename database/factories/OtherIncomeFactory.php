<?php

namespace Database\Factories;

use App\Models\IncomeSource;
use Illuminate\Database\Eloquent\Factories\Factory;

class OtherIncomeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'source_id' => IncomeSource::factory(),
            'income_amount' => fake()->numberBetween(500, 20000),
            'income_date' => fake()->date(),
        ];
    }
}