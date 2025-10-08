<?php

namespace Database\Factories;

use App\Models\Training;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrainingFactory extends Factory
{
    protected $model = Training::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'employee_id' => Employee::factory(),
            'topic' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->city(),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'laporan_pasca_pelatihan' => 'laporan_pelatihan/' . $this->faker->uuid . '.pdf',
            'evaluasi_pasca_pelatihan' => 'evaluasi_pelatihan/' . $this->faker->uuid . '.pdf',
        ];
    }
}
