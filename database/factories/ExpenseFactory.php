<?php

namespace Database\Factories;

use App\Models\Chartofaccount;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'account_id' => Chartofaccount::factory(),
            'expense_amount' => fake()->numberBetween(500, 15000),
            'expense_date' => fake()->date(),
            'remark' => fake()->optional()->sentence(),
        ];
    }
}