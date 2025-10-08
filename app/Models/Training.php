<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'user_id',
        'topic',
        'description',
        'location',
        'start_date',
        'end_date',
        'laporan_pasca_pelatihan',
        'evaluasi_pasca_pelatihan',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
