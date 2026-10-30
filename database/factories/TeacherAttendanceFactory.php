<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherAttendanceFactory extends Factory
{
    public function definition(): array
    {
        $date = fake()->dateTimeBetween('-1 year', 'now');

        return [
            'teacher_id' => Teacher::factory(),
            'absent_year' => (int) $date->format('Y'),
            'absent_month' => (int) $date->format('m'),
            'absent_day' => (int) $date->format('d'),
            'remark' => fake()->optional()->sentence(),
        ];
    }
}