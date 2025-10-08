<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'position',
        'department',
        'start_date',
        'end_date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
