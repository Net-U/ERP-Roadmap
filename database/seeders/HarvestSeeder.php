<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Harvest;
use App\Models\Employee;
use App\Models\BlokKebun;
use Carbon\Carbon;

class HarvestSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();
        $blok = BlokKebun::inRandomOrder()->first();

        if ($employees->isEmpty() || !$blok) {
            $this->command->warn('⚠️ Tidak ada data karyawan atau blok kebun. Seeder dibatalkan.');
            return;
        }

        Harvest::truncate();

        foreach ($employees as $emp) {
            // ✅ hanya 3 hari terakhir
            for ($i = 0; $i < 3; $i++) {
                $tanggal = Carbon::today()->subDays($i);

                Harvest::create([
                    'employee_id' => $emp->id,
                    'blok_kebun_id' => $blok->id,
                    'afd' => 'AFD-' . rand(1, 3),
                    'kerja' => 'Panen',
                    'ttl_janjang' => rand(60, 150),
                    'tonase' => rand(3, 9) + (rand(0, 99) / 100),
                    'tanggal_panen' => $tanggal,
                ]);
            }
        }

        $this->command->info('✅ Data panen berhasil dibuat untuk 3 hari terakhir semua karyawan.');
    }
}
