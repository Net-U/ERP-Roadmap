<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Maatwebsite\Excel\Facades\Excel;         // ← tambahkan
use App\Exports\DynamicExport;              // ← jika pakai export dinamis
// use App\Exports\EmployeesExport;        // ← jika pakai export khusus


class Employee extends Model
{
    use HasFactory;

    /**
     * Field yang bisa diisi massal
     */
    protected $fillable = [
        'name',
        'nrk',
        'nik_sap',
        'identity_number',
        'join_date',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'religion',
        'blood_type',
        'email',
        'phone',
        'address',
        'district',
        'city',
        'education',
        'education_major',
        'bank_account',
        'bpjs_tk',
        'bpjs_ks',
        'npwp',
        'subdivision',
        'spouse_job',
        'marital_status',
        'spouse_name',
        'children_count',
        'vaccine_1',
        'vaccine_2',
        'vaccine_3',
        'photo',
        'user_id',
        'department_id',
        'position_id',
        'grade_id',
        'heir_name',
        'heir_relationship',
        'heir_phone',
        'heir_address',
    ];

    /**
     * Casting otomatis ke tipe data tertentu
     */
    protected $casts = [
        'join_date' => 'date',
        'date_of_birth' => 'date',
        'vaccine_1' => 'boolean',
        'vaccine_2' => 'boolean',
        'vaccine_3' => 'boolean',
        'children_count' => 'integer',
    ];

    /**
     * Relasi: Employee dimiliki oleh satu user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Employee punya satu department
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Relasi: Employee punya satu posisi
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Relasi: Employee punya satu grade
     */
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    // App\Models\Employee.php

    public function calculateAnnualLeave()
    {
        if (!$this->join_date) return 0;

        $years = \Carbon\Carbon::parse($this->join_date)->diffInYears(now());

        return $years * 12; // misalnya 12 hari cuti/tahun
    }

    /**
     * Relasi: Employee memiliki banyak kehadiran
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function jobHistories() {
        return $this->hasMany(JobHistory::class);
    }

    public function penalties() {
        return $this->hasMany(Penalty::class);
    }

    public function trainings() {
        return $this->hasMany(Training::class);
    }


    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

    public function latestSalary()
    {
        return $this->hasOne(Salary::class)->latestOfMany(); // Laravel 9+ fitur `latestOfMany()`
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }


    public function export()
    {
        // Ambil data
        $employees = Employee::with('grade', 'position')->get()->map(function ($e) {
            return [
                'Nama'   => $e->name,
                'NRK'    => $e->nrk,
                'NIK SAP'=> $e->nik_sap,
                'Email'  => $e->email,
                'Posisi' => $e->position->name ?? '-',
                'Grade'  => $e->grade
                            ? $e->grade->code . ' - ' . $e->grade->grade_name
                            : '-',
                'Tanggal Masuk' => $e->join_date,
            ];
        });

        // Headings untuk Excel
        $headings = ['Nama','NRK','NIK SAP','Email','Posisi','Grade','Tanggal Masuk'];

        // Download
        return Excel::download(
            new DynamicExport($employees, $headings),
            'data_karyawan.xlsx'
        );
    }



}
