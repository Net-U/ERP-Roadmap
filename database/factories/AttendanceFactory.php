<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'employee_id' => Employee::inRandomOrder()->first()?->id,
            'date' => fake()->dateTimeBetween('-1 month', 'now'),
            'status' => fake()->randomElement(['hadir', 'izin', 'sakit', 'alpha']),
        ];
    }
}
