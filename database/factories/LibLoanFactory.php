<?php

namespace Database\Factories;

use App\Models\LibMember;
use App\Models\LibBook;
use Illuminate\Database\Eloquent\Factories\Factory;

class LibLoanFactory extends Factory
{
    public function definition(): array
    {
        $loanDate = fake()->dateTimeBetween('-1 year', 'now');

        return [
            'student_id' => LibMember::factory(),
            'book_id' => LibBook::factory(),
            'loan_date' => $loanDate->format('Y-m-d'),
            'return_date' => fake()->optional()->dateTimeBetween(
                $loanDate,
                'now'
            )?->format('Y-m-d'),
        ];
    }
}