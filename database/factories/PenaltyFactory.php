<?php

namespace Database\Factories;

use App\Models\Penalty;
use Illuminate\Database\Eloquent\Factories\Factory;

class PenaltyFactory extends Factory
{
    protected $model = Penalty::class;

    public function definition(): array
    {
        return [
            'type'       => $this->faker->randomElement(['SP1', 'SP2', 'SP3']),
            'reason'     => $this->faker->sentence(),
            'date'       => $this->faker->date(),
        ];
    }
}
