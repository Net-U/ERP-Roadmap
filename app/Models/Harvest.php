<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harvest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'blok_kebun_id',
        'afd',
        'kerja',
        'ttl_janjang',
        'tonase',
        'tanggal_panen',
    ];

    // Relasi ke pekerja
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Relasi ke blok kebun
    public function blokKebun()
    {
        return $this->belongsTo(BlokKebun::class);
    }
}
