<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    public function definition(): array
    {
        return [
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'fathername' => fake()->firstName(),
            'gender' => fake()->boolean(),
            'birth_year' => fake()->numberBetween(1970, 2000),
            'photo' => 'teachers/default.jpg',
            'phone' => fake()->unique()->numerify('07########'),
            'email' => fake()->unique()->safeEmail(),
            'province' => fake()->city(),
            'district' => fake()->city(),
            'village' => fake()->city(),
            'current_address' => fake()->address(),
            'education_degree' => 'Bachelor',
            'education_field' => 'Computer Science',
            'education_university' => 'Parwan University',
            'education_year' => fake()->numberBetween(2000, 2025),
            'talent_score' => fake()->numberBetween(50, 100),
            'gross_salary' => fake()->numberBetween(10000, 30000),
            'hod_bonus' => 0,
            'academic_bonus' => 0,
            'food_charge' => 0,
            'talent_bonus' => 0,
            'status' => true,
        ];
    }
}