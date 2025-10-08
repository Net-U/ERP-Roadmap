<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use App\Models\Grade;
use App\Models\Attendance;
use App\Models\Training;
use App\Models\JobHistory;
use App\Models\Penalty;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Attendance::truncate();
        Employee::truncate();
        Department::truncate();
        Position::truncate();
        Grade::truncate();
        Training::truncate();
        JobHistory::truncate();
        Penalty::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $departments = Department::factory(5)->create();
        $positions   = Position::factory(5)->create();
        $grades      = Grade::factory(5)->create();

        // Distribusi jumlah karyawan per grade
        $jumlahPerGrade = [5, 15, 10, 12, 8]; // total 50

        foreach ($grades as $i => $grade) {
            $jumlah = $jumlahPerGrade[$i];

            $employees = Employee::factory($jumlah)->create();

            foreach ($employees as $employee) {
                $employee->update([
                    'department_id' => $departments->random()->id,
                    'position_id'   => $positions->random()->id,
                    'grade_id'      => $grade->id,
                ]);

                // Absensi
                Attendance::factory(20)->create([
                    'employee_id' => $employee->id
                ]);

                // Pelatihan
                Training::create([
                    'employee_id' => $employee->id,
                    'topic'       => 'Laravel Fundamentals',
                    'location'    => 'Jakarta',
                    'start_date'  => now()->subYears(2)->format('Y-m-d'),
                    'end_date'    => now()->subYears(2)->addDays(2)->format('Y-m-d'),
                ]);
                Training::create([
                    'employee_id' => $employee->id,
                    'topic'       => 'Leadership Development',
                    'location'    => 'Bandung',
                    'start_date'  => now()->subYear()->format('Y-m-d'),
                    'end_date'    => now()->subYear()->addDays(3)->format('Y-m-d'),
                ]);

                // Riwayat jabatan
                JobHistory::create([
                    'employee_id'   => $employee->id,
                    'position_name' => 'Staf IT',
                    'start_date'    => now()->subYears(3)->format('Y-m-d'),
                    'end_date'      => now()->subYears(1)->format('Y-m-d'),
                ]);
                JobHistory::create([
                    'employee_id'   => $employee->id,
                    'position_name' => 'Senior Developer',
                    'start_date'    => now()->subYears(1)->format('Y-m-d'),
                    'end_date'      => null,
                ]);

                // Penalty kadang-kadang
                if (rand(0, 1)) {
                    Penalty::create([
                        'employee_id' => $employee->id,
                        'type'        => 'SP 1',
                        'description' => 'Terlambat masuk kerja 3 hari berturut-turut',
                        'date'        => now()->subMonths(rand(2, 12))->format('Y-m-d'),
                    ]);
                }
            }
        }
    }
}
