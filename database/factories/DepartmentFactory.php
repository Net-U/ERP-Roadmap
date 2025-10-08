<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
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
                'Human Resources', 'Information Technology', 'Marketing', 'Sales', 'Finance',
                // Tambahkan nama departemen yang Anda inginkan disini
            ]),
            'description' => $this->faker->sentence(10, 20),
        ];
    }
}