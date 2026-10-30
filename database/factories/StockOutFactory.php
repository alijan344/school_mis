<?php

namespace Database\Factories;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockOutFactory extends Factory
{
    public function definition(): array
    {
        return [
            'stock_id' => Stock::factory(),
            'out_date' => fake()->date(),
            'out_quantity' => fake()->randomFloat(2, 1, 50),
            'remark' => fake()->optional()->sentence(),
        ];
    }
}