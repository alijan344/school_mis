<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StaffFactory extends Factory
{
    public function definition(): array
    {
        return [
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'fathername' => fake()->firstName(),
            'gender' => fake()->boolean(),
            'birth_year' => fake()->numberBetween(1970, 2000),
            'photo' => 'staff/default.jpg',
            'nic' => fake()->unique()->numerify('##########'),
            'phone' => fake()->unique()->numerify('07########'),
            'email' => fake()->unique()->safeEmail(),
            'province' => fake()->city(),
            'district' => fake()->city(),
            'village' => fake()->city(),
            'current_address' => fake()->address(),
            'position' => fake()->randomElement([
                'Manager',
                'Accountant',
                'Secretary',
                'Assistant',
            ]),
            'gross_salary' => fake()->numberBetween(8000, 20000),
            'status' => true,
        ];
    }
}