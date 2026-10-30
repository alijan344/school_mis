<?php

namespace Database\Factories;

use App\Models\Staff;
use App\Models\StaffAttendance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StaffAttendance>
 */
class StaffAttendanceFactory extends Factory
{
    protected $model = StaffAttendance::class;

    public function definition(): array
    {
        $date = fake()->dateTimeBetween('-1 year', 'now');

        return [
            'staff_id' => Staff::factory(),
            'absent_year' => (int) $date->format('Y'),
            'absent_month' => (int) $date->format('m'),
            'absent_day' => (int) $date->format('d'),
            'remark' => fake()->optional()->sentence(),
        ];
    }
}