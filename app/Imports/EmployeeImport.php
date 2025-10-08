<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class EmployeeImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Jika keduanya kosong, lewati baris
        if (empty($row['department_id']) || empty($row['position_id'])) {
            // Kamu juga bisa log: \Log::warning("Baris dilewati karena kolom wajib kosong.", $row);
            return null; // skip baris tanpa error
        }

        // Normalisasi status menikah
        $statusRaw = trim((string) ($row['marital_status'] ?? ''));
        $statusMap = [
            '1' => 'Lajang', 'LAJANG' => 'Lajang', 'SINGLE' => 'Lajang', 'L' => 'Lajang',
            '2' => 'Menikah', 'MENIKAH' => 'Menikah', 'MARRIED' => 'Menikah', 'M' => 'Menikah',
        ];
        $maritalStatus = $statusMap[strtoupper($statusRaw)] ?? null;

        // Validasi user_id
        $userId = $row['user_id'] ?? null;
        if ($userId && !User::find($userId)) {
            $userId = null;
        }

        // Cari employee jika sudah ada
        $employee = Employee::query()
            ->where('email', $row['email'] ?? null)
            ->orWhere('nrk', $row['nrk'] ?? null)
            ->orWhere('nik_sap', $row['nik_sap'] ?? null)
            ->orWhere('identity_number', $row['identity_number'] ?? null)
            ->first() ?? new Employee();

        // Isi data
        $employee->fill([
            'name'            => $row['name'] ?? null,
            'nrk'             => $row['nrk'] ?? null,
            'nik_sap'         => $row['nik_sap'] ?? null,
            'identity_number' => $row['identity_number'] ?? null,
            'join_date'       => $this->transformDate($row['join_date'] ?? null),
            'date_of_birth'   => $this->transformDate($row['date_of_birth'] ?? null),
            'place_of_birth'  => $row['place_of_birth'] ?? null,
            'gender'          => $row['gender'] ?? null,
            'religion'        => $row['religion'] ?? null,
            'blood_type'      => $row['blood_type'] ?? null,
            'email'           => $row['email'] ?? null,
            'phone'           => $row['phone'] ?? null,
            'address'         => $row['address'] ?? null,
            'district'        => $row['district'] ?? null,
            'city'            => $row['city'] ?? null,
            'education'       => $row['education'] ?? null,
            'education_major' => $row['education_major'] ?? null,
            'bank_account'    => $row['bank_account'] ?? null,
            'bpjs_tk'         => $row['bpjs_tk'] ?? null,
            'bpjs_ks'         => $row['bpjs_ks'] ?? null,
            'npwp'            => $row['npwp'] ?? null,
            'subdivision'     => $row['subdivision'] ?? null,
            'spouse_name'       => $row['spouse_name'] ?? null, // nama istri
            'spouse_job'      => $row['spouse_job'] ?? null,
            'marital_status'  => $maritalStatus,
            'children_count'  => $row['children_count'] ?? null,
            'vaccine_1'       => (bool) ($row['vaccine_1'] ?? 0),
            'vaccine_2'       => (bool) ($row['vaccine_2'] ?? 0),
            'vaccine_3'       => (bool) ($row['vaccine_3'] ?? 0),
            'photo'           => $row['photo'] ?? null,
            'user_id'         => $userId,
            'department_id'   => $row['department_id'],
            'position_id'     => $row['position_id'],
            'grade_id'        => $row['grade_id'] ?? null,
            'heir_name'         => $row['heir_name'] ?? null,
            'heir_relationship' => $row['heir_relationship'] ?? null,
            'heir_phone'        => $row['heir_phone'] ?? null,
            'heir_address'      => $row['heir_address'] ?? null,
        ]);

        $employee->save();
        return null;
    }

    private function transformDate($value)
    {
        try {
            return is_numeric($value)
                ? Date::excelToDateTimeObject($value)->format('Y-m-d')
                : date('Y-m-d', strtotime($value));
        } catch (\Exception $e) {
            return null;
        }
    }
}
