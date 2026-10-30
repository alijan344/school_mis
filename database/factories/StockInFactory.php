<?php

namespace Database\Factories;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockInFactory extends Factory
{
    public function definition(): array
    {
        return [
            'stock_id' => Stock::factory(),
            'in_date' => fake()->date(),
            'in_quantity' => fake()->randomFloat(2, 1, 100),
            'remark' => fake()->optional()->sentence(),
        ];
    }
}