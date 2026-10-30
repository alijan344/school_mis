<?php

namespace Database\Factories;

use App\Models\ClassSection;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'reg_no' => fake()->unique()->numerify('STU-######'),
            'firstname' => fake()->firstName(),
            'fathername' => fake()->firstName(),
            'grandfathername' => fake()->firstName(),
            'gender' => fake()->boolean(),
            'birth_year' => fake()->numberBetween(2005, 2015),
            'province' => fake()->city(),
            'district' => fake()->city(),
            'current_address' => fake()->address(),
            'nic' => fake()->numerify('##########'),
            'phone' => fake()->numerify('07########'),
            'photo' => 'students/default.jpg',
            'status' => 1,
            'section_id' => ClassSection::factory(),
        ];
    }
}