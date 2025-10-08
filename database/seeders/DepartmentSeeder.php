<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            // Master department (utama)
            'Dewan Komisaris',
            'Anggota Komisaris',
            'Direksi',
            'SEVP',
            'SPI',
            'Pengembangan Usaha',
            'Corporate Secretary, Legal & Humas',
            'SDM, Umum & Pengadaan',
            'Teknik, Pemeliharaan & Tank Farm',
            'Akuntansi, Keuangan & Sistem Manajemen',
            'WTP & WWTP',
            'Pemasaran',

            // Sub-departemen
            'Legal & Humas',
            'WWTP',
            'Tank Farm',
            'Pemeliharaan Kawasan',
            'Mekanikal/Elektrikal',
            'SDM',
            'Pengadaan',
            'Keuangan',
            'WTP',
            'Umum',
            'Sistem Manajemen',
            'Corporate Secretary',
        ];

        foreach ($departments as $index => $name) {
            Department::updateOrCreate(
                ['name' => $name],
                ['id' => $index + 1] // opsional jika kamu ingin set ID manual
            );
        }

        $this->command->info('✅ DepartmentSeeder selesai.');
    }
}
