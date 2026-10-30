<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScoreFactory extends Factory
{
    public function definition(): array
    {
        $mid = fake()->numberBetween(0, 40);
        $final = fake()->numberBetween(0, 60);

        return [
            'student_id' => Student::factory(),
            'subject_id' => Subject::factory(),
            'section_id' => function (array $attributes) {
                return Student::find($attributes['student_id'])->section_id;
            },
            'exam_year' => 2026,
            'mid_exam' => $mid,
            'final_exam' => $final,
            'second_chance' => null,
            'total_mark' => $mid + $final,
        ];
    }
}