<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    public function definition(): array
    {
        return [
            'item_name' => fake()->unique()->words(2, true),
            'unit' => fake()->randomElement(['Piece', 'Kg', 'Liter', 'Box']),
            'quantity' => fake()->randomFloat(2, 1, 500),
        ];
    }
}