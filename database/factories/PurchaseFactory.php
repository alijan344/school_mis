<?php

namespace Database\Factories;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    public function definition(): array
    {
        $quantity = fake()->randomFloat(2, 1, 100);
        $unitPrice = fake()->numberBetween(100, 5000);

        return [
            'staff_id' => Staff::factory(),
            'purchase_date' => fake()->date(),
            'item_name' => fake()->word(),
            'unit' => fake()->randomElement(['Piece', 'Kg', 'Box', 'Liter']),
            'quantity' => $quantity,
            'unitprice' => $unitPrice,
            'totalprice' => (int) round($quantity * $unitPrice),
        ];
    }
}