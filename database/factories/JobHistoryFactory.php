<?php

namespace Database\Factories;

use App\Models\JobHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobHistoryFactory extends Factory
{
    protected $model = JobHistory::class; // ⬅️ Penting: kaitkan dengan model

    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-5 years', '-1 year');
        $end = $this->faker->boolean(70) ? $this->faker->dateTimeBetween($start, 'now') : null;

        return [
            'position'    => $this->faker->jobTitle(),
            'department'  => $this->faker->randomElement(['IT', 'HR', 'Finance', 'Marketing']),
            'start_date'  => $start->format('Y-m-d'),
            'end_date'    => $end ? $end->format('Y-m-d') : null,
        ];
    }
}
