<?php

namespace Database\Factories;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'staff_id' => Staff::factory(),
            'username' => fake()->unique()->userName(),
            'password' => Hash::make('password'),
        ];
    }
}