<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Employee;

class Salary extends Model
{
    use HasFactory;

    // Jika nama tabelnya bukan "salaries", maka aktifkan ini:
    // protected $table = 'nama_tabel';

    protected $fillable = [
        'employee_id',
        'year',
        'month',
        'basic_salary',
        'tunjangan_keluarga',
        'tunjangan_kematian',
        'tunjangan_lainnya',
        'deduction',
    ];

    // Tipe data agar Laravel otomatis cast ke tipe yang sesuai
    protected $casts = [
        'year' => 'integer',
        'month' => 'integer',
        'basic_salary' => 'float',
        'tunjangan_keluarga' => 'float',
        'tunjangan_kematian' => 'float',
        'tunjangan_lainnya' => 'float',
        'deduction' => 'float',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
