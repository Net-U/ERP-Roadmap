<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Position>
 */
class PositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement([
                'Manager', 'Supervisor', 'Staff', 'Assistant', 'Director',
                // Tambahkan nama posisi yang Anda inginkan disini
            ]),
            'description' => $this->faker->sentence(10, 20),
        ];
    }
}
