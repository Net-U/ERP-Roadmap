<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Department;
use App\Models\Position;
use App\Models\Grade;

class EmployeeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'              => $this->faker->name(),
            'nrk'               => $this->faker->unique()->numerify('NRK#####'),
            'nik_sap'           => $this->faker->unique()->numerify('SAP########'),
            'join_date'         => $this->faker->dateTimeBetween('-5 years', 'now'),
            'place_of_birth'    => $this->faker->city(),
            'date_of_birth'     => $this->faker->date('Y-m-d', '-20 years'),
            'gender'            => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'religion'          => $this->faker->randomElement(['Islam', 'Kristen', 'Hindu', 'Buddha', 'Katolik']),
            'blood_type'        => $this->faker->randomElement(['A', 'B', 'AB', 'O']),
            'email'             => $this->faker->unique()->safeEmail(),
            'phone'             => $this->faker->phoneNumber(),
            'address'           => $this->faker->address(),
            'district'          => $this->faker->citySuffix(),
            'city'              => $this->faker->city(),
            'education'         => $this->faker->randomElement(['SMA', 'D3', 'S1', 'S2']),
            'education_major'   => $this->faker->randomElement(['Teknik Informatika', 'Akuntansi', 'Manajemen', 'Pertanian']),
            'identity_number'   => $this->faker->numerify('################'),
            'bpjs_tk'           => $this->faker->numerify('TK##########'),
            'bpjs_ks'           => $this->faker->numerify('KS##########'),
            'npwp'              => $this->faker->numerify('##.###.###.#-###.###'),
            'subdivision'       => $this->faker->word(),
            'bank_account'      => $this->faker->bankAccountNumber(),
            'spouse_job'        => $this->faker->randomElement(['Ibu Rumah Tangga', 'Pegawai Swasta', 'PNS', 'Wiraswasta']),
            'marital_status'    => $this->faker->randomElement(['Lajang', 'Menikah']),
            'children_count'    => $this->faker->numberBetween(0, 4),
            'vaccine_1'         => $this->faker->boolean(),
            'vaccine_2'         => $this->faker->boolean(),
            'vaccine_3'         => $this->faker->boolean(),
            'photo'             => 'photos/dummy' . rand(1, 3) . '.jpg',

            'department_id'     => Department::inRandomOrder()->first()?->id,
            'position_id'       => Position::inRandomOrder()->first()?->id,
            'grade_id'          => Grade::inRandomOrder()->first()?->id,
        ];
    }
}
