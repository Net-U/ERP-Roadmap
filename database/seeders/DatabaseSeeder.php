<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use App\Models\Grade;
use App\Models\JobHistory;
use App\Models\Penalty;
use App\Models\Training;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        User::truncate();
        Employee::truncate();
        Department::truncate();
        Position::truncate();
        Grade::truncate();
        JobHistory::truncate();
        Training::truncate();
        Penalty::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // 🧹 Panggil seeder untuk department dan posisi
        $this->call([
            DepartmentSeeder::class,
            PositionSeeder::class,
        ]);

        // 🎓 Buat 30 grade dengan variasi level dan type
        $grades = Grade::factory(10)->create();

        // 👤 Admin user + data karyawan
        $adminUser = User::create([
            'name'     => 'Neet',
            'username' => 'ilham',
            'email'    => 'milham1358@gmail.com',
            'password' => bcrypt('123456'),
            'role'     => 'admin',
        ]);

        // Ambil satu departemen & posisi acak untuk admin
        $adminDept  = Department::inRandomOrder()->first();
        $adminPos   = Position::inRandomOrder()->first();
        $adminGrade = $grades->random();

        // 👨‍💼 Data Karyawan untuk Admin
        Employee::create([
            'name'              => 'Neet Admin',
            'nrk'               => 'EMP000',
            'nik_sap'           => 'SAP00000000',
            'join_date'         => now(),
            'place_of_birth'    => 'Jakarta',
            'date_of_birth'     => '1990-01-01',
            'gender'            => 'Laki-laki',
            'religion'          => 'Islam',
            'blood_type'        => 'A',
            'email'             => 'milham1358@gmail.com',
            'phone'             => '08111111111',
            'address'           => 'Jl. Admin Raya No. 1',
            'district'          => 'Admin Distrik',
            'city'              => 'Jakarta',
            'education'         => 'S2',
            'education_major'   => 'Manajemen',
            'identity_number'   => '3275010101900001',
            'bpjs_tk'           => 'TK00000000',
            'bpjs_ks'           => 'KS00000000',
            'npwp'              => '00.000.000.0-000.000',
            'subdivision'       => 'Administrasi',
            'bank_account'      => '0000000000',
            'spouse_job'        => 'Ibu Rumah Tangga',
            'marital_status'    => 'Menikah',
            'children_count'    => 1,
            'vaccine_1'         => true,
            'vaccine_2'         => true,
            'vaccine_3'         => true,
            'photo'             => 'photos/dammy2.jpg',
            'user_id'           => $adminUser->id,
            'department_id'     => $adminDept->id,
            'position_id'       => $adminPos->id,
            'grade_id'          => $adminGrade->id,
        ]);


        // 👤 User biasa
        $user = User::create([
            'name'     => 'User',
            'username' => 'user',
            'email'    => 'user@gmail.com',
            'password' => bcrypt('123456'),
            'role'     => 'user',
        ]);

        // Ambil satu departemen & posisi acak untuk Ilham
        $department = Department::inRandomOrder()->first();
        $position   = Position::inRandomOrder()->first();
        $mainGrade  = $grades->random();

        // 👨‍💼 Buat 1 karyawan utama
        $employee = Employee::create([
            'name'              => 'Ilham Saputra',
            'nrk'               => 'EMP001',
            'nik_sap'           => 'SAP12345678',
            'join_date'         => now(),
            'place_of_birth'    => 'Bandung',
            'date_of_birth'     => '1998-08-12',
            'gender'            => 'Laki-laki',
            'religion'          => 'Islam',
            'blood_type'        => 'O',
            'email'             => 'user@gmail.com',
            'phone'             => '08123456789',
            'address'           => 'Jl. Kebun Raya No. 123',
            'district'          => 'Kiaracondong',
            'city'              => 'Bandung',
            'education'         => 'S1',
            'education_major'   => 'Teknik Informatika',
            'identity_number'   => '3275081208980001',
            'bpjs_tk'           => 'TK12345678',
            'bpjs_ks'           => 'KS87654321',
            'npwp'              => '12.345.678.9-012.345',
            'subdivision'       => 'Pengembangan',
            'bank_account'      => '1234567890',
            'spouse_job'        => 'Ibu Rumah Tangga',
            'marital_status'    => 'Menikah',
            'children_count'    => 2,
            'vaccine_1'         => true,
            'vaccine_2'         => true,
            'vaccine_3'         => false,
            'photo'             => 'photos/dummy1.jpg',
            'user_id'           => $user->id,
            'department_id'     => $department->id,
            'position_id'       => $position->id,
            'grade_id'          => $mainGrade->id,
        ]);

        JobHistory::factory(2)->create(['employee_id' => $employee->id]);
        Training::factory(2)->create(['employee_id' => $employee->id]);
        Penalty::factory()->create(['employee_id' => $employee->id]);

        // 👥 Tambah banyak karyawan berdasarkan type Grade
        $jumlahPerGrade = [
            'PKWT'       => 3,
            'PKWTT'      => 3,
            'Honorarium' => 4,
        ];

        foreach ($jumlahPerGrade as $type => $jumlah) {
            $filteredGrades = $grades->where('type', $type);
            if ($filteredGrades->isEmpty()) continue;

            for ($i = 0; $i < $jumlah; $i++) {
                $grade = $filteredGrades->random();

                $emp = Employee::factory()->create([
                    'department_id' => Department::inRandomOrder()->first()->id,
                    'position_id'   => Position::inRandomOrder()->first()->id,
                    'grade_id'      => $grade->id,
                ]);

                JobHistory::factory(2)->create(['employee_id' => $emp->id]);
                Training::factory(2)->create(['employee_id' => $emp->id]);

                if (rand(0, 1)) {
                    Penalty::factory()->create(['employee_id' => $emp->id]);
                }
            }
        }
    }
}
