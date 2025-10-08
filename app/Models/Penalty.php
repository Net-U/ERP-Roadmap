<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penalty extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'type',         // contoh: SP1, SP2, Teguran, dll
        'description',
        'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
