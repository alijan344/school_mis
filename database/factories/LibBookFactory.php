<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LibBookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'isbn' => fake()->optional()->isbn13(),
            'book_name' => fake()->sentence(3),
            'author' => fake()->optional()->name(),
            'publish_year' => fake()->optional()->numberBetween(1990, 2026),
            'publisher' => fake()->optional()->company(),
            'shelf' => fake()->bothify('SHELF-##'),
            'shelf_row' => fake()->bothify('ROW-##'),
        ];
    }
}