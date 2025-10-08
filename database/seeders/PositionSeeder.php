<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    public function run(): void
    {

        // ── Posisi lengkap: id, name, department_id ───────────────────────────────
        $positions = [
            ['id' =>  1, 'name' => 'Komisaris Utama',                                                        'department_id' => 1],
            ['id' =>  2, 'name' => 'Komisaris Independent',                                                  'department_id' => 2],
            ['id' =>  3, 'name' => 'Sekretaris Komisaris',                                                   'department_id' => 3],
            ['id' =>  4, 'name' => 'Anggota Komite Good Corporate Governance & Pemantauan Manajemen Risiko', 'department_id' => 4],
            ['id' =>  5, 'name' => 'Anggota Komite Audit',                                                   'department_id' => 5],
            ['id' =>  6, 'name' => 'Plt. Direktur',                                                          'department_id' => 6],
            ['id' =>  7, 'name' => 'SEVP Business Support',                                                  'department_id' => 7],
            ['id' =>  8, 'name' => 'SEVP Operation',                                                         'department_id' => 8],
            ['id' =>  9, 'name' => 'Kepala SPI',                                                             'department_id' => 9],
            ['id' => 10, 'name' => 'Manager Pengembangan Usaha',                                             'department_id' => 10],
            ['id' => 11, 'name' => 'Manager Corporate Secretary, Legal & Humas',                             'department_id' => 11],
            ['id' => 12, 'name' => 'Manager SDM, Umum & Pengadaan',                                          'department_id' => 12],
            ['id' => 13, 'name' => 'Manager Teknik, Pemeliharaan & Tank Farm',                               'department_id' => 13],
            ['id' => 14, 'name' => 'Manager Akuntansi, Keuangan & Sistem Manajemen',                         'department_id' => 14],
            ['id' => 15, 'name' => 'Asisten Manager WWTP',                                                   'department_id' => 15],
            ['id' => 16, 'name' => 'Asisten Manager Legal & Humas',                                          'department_id' => 11],
            ['id' => 17, 'name' => 'Manager WTP & WWTP',                                                     'department_id' => 15],
            ['id' => 18, 'name' => 'Manager Pemasaran',                                                      'department_id' => 16],
            ['id' => 19, 'name' => 'Asisten Manager Tank Farm',                                              'department_id' => 13],
            ['id' => 20, 'name' => 'Asisten Manager Pemeliharaan Kawasan',                                   'department_id' => 13],
            ['id' => 21, 'name' => 'Asisten Manager Mekanikal/Elektrikal',                                   'department_id' => 13],
            ['id' => 22, 'name' => 'Asisten Manager SDM',                                                    'department_id' => 12],
            ['id' => 23, 'name' => 'Asisten Manager Pengadaan',                                              'department_id' => 12],
            ['id' => 24, 'name' => 'Asisten Manager Pengembangan Usaha',                                     'department_id' => 10],
            ['id' => 25, 'name' => 'Pj. Asisten Manager Keuangan',                                           'department_id' => 14],
            ['id' => 26, 'name' => 'Kepala Laboratorium',                                                    'department_id' => 15],
            ['id' => 27, 'name' => 'Operator WTP',                                                           'department_id' => 15],
            ['id' => 28, 'name' => 'Supervisor Pemeliharaan',                                                'department_id' => 13],
            ['id' => 29, 'name' => 'Admi Pemeliharaan',                                                      'department_id' => 13],
            ['id' => 30, 'name' => 'Supir Damkar',                                                           'department_id' => 13],
            ['id' => 31, 'name' => 'Operator WWTP',                                                          'department_id' => 15],
            ['id' => 32, 'name' => 'Supervisor Mekanikal/Elektrikal',                                        'department_id' => 13],
            ['id' => 33, 'name' => 'Admi Umum',                                                              'department_id' => 12],
            ['id' => 34, 'name' => 'Admi IT',                                                                'department_id' => 16],
            ['id' => 35, 'name' => 'Petugas Gudang',                                                         'department_id' => 15],
            ['id' => 36, 'name' => 'Supervisor WWTP',                                                        'department_id' => 15],
            ['id' => 37, 'name' => 'Operator Intake',                                                        'department_id' => 15],
            ['id' => 38, 'name' => 'Supir Dump Truck',                                                       'department_id' => 13],
            ['id' => 39, 'name' => 'Supervisor Operasional Tank Farm',                                       'department_id' => 13],
            ['id' => 40, 'name' => 'Admi Pemasaran',                                                         'department_id' => 16],
            ['id' => 41, 'name' => 'Supervisor Surveyor',                                                    'department_id' => 15],
            ['id' => 42, 'name' => 'Koordinator Keamanan',                                                   'department_id' => 16],
            ['id' => 43, 'name' => 'Operator Mekanikal/Elektrikal',                                          'department_id' => 13],
            ['id' => 44, 'name' => 'Supervisor WTP',                                                         'department_id' => 15],
            ['id' => 45, 'name' => 'Operator Pemeliharaan',                                                  'department_id' => 13],
            ['id' => 46, 'name' => 'Admi WWTP',                                                              'department_id' => 15],
            ['id' => 47, 'name' => 'Auditor Junior Bidang Keuangan, Umum & Kepatuhan',                       'department_id' => 14],
            ['id' => 48, 'name' => 'Pj. Supervisor Diperbantukan',                                           'department_id' => 15],
            ['id' => 49, 'name' => 'Operator Timbang',                                                       'department_id' => 13],
            ['id' => 50, 'name' => 'Admi Data',                                                              'department_id' => 15],
            ['id' => 51, 'name' => 'Admi Keuangan & Komersil',                                               'department_id' => 14],
            ['id' => 52, 'name' => 'Admi Umum & Keamanan',                                                   'department_id' => 12],
            ['id' => 53, 'name' => 'Admi SDM',                                                               'department_id' => 12],
            ['id' => 54, 'name' => 'Admi Humas',                                                             'department_id' => 11],
            ['id' => 55, 'name' => 'Admi Keuangan',                                                          'department_id' => 14],
            ['id' => 56, 'name' => 'Operator Loading/Unloading',                                             'department_id' => 15],
            ['id' => 57, 'name' => 'Analis Laboratorium',                                                    'department_id' => 15],
            ['id' => 58, 'name' => 'Admi Pengembangan Usaha',                                                'department_id' => 10],
            ['id' => 59, 'name' => 'Admi Tank Farm',                                                         'department_id' => 13],
            ['id' => 60, 'name' => 'Admi WTP',                                                               'department_id' => 15],
            ['id' => 61, 'name' => 'Admi SPI',                                                               'department_id' => 9],
            ['id' => 62, 'name' => 'Operator Sounding',                                                      'department_id' => 13],
            ['id' => 63, 'name' => 'Admi Legal',                                                             'department_id' => 11],
            ['id' => 64, 'name' => 'Operator Pompa',                                                         'department_id' => 13],
            ['id' => 65, 'name' => 'Admi Pengadaan',                                                         'department_id' => 12],
            ['id' => 66, 'name' => 'Supir',                                                                  'department_id' => 12],
            ['id' => 67, 'name' => 'Kebersihan Kantor',                                                      'department_id' => 12],
            ['id' => 68, 'name' => 'Asisten Manager Sistem Manajemen & Manajemen Risiko',                    'department_id' => 14],
            ['id' => 69, 'name' => 'Asisten Manager Corporate Secretary',                                    'department_id' => 11],
            ['id' => 70, 'name' => 'Admi Surveyor',                                                          'department_id' => 11],
            ['id' => 71, 'name' => 'Supervisor Keuangan',                                                    'department_id' => 14],
            ['id' => 72, 'name' => 'Admi Sistem Manajemen & Manajemen Risiko',                               'department_id' => 14],
            ['id' => 73, 'name' => 'Koordinator BKO',                                                        'department_id' => 13],
        ];


        foreach ($positions as $data) {
            Position::updateOrCreate(
                ['id' => $data['id']],  // kunci pencarian
                [
                    'name' => $data['name'],
                    'department_id' => $data['department_id'],
                ]
            );
        }

        $this->command->info('✅ PositionSeeder selesai tanpa truncate.');
    }
}