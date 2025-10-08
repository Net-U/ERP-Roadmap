<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grade>
 */
class GradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
        public function definition(): array
        {
            $type  = $this->faker->randomElement(['Honorarium','PKWT','PKWTT']);
            $level = $this->faker->randomElement([6,7,8,10,11,12,15,16]);

            return [
                'code'        => "{$type}-{$level}",
                'type'        => $type,
                'level'       => $level,
                'description' => $this->faker->sentence(8),
                'grade_name'  => "{$type} Grade {$level}",
            ];
        }
}
   