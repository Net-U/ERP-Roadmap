<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    // Tidak perlu memasukkan 'id' ke $fillable, karena 'id' sudah otomatis di-handle Laravel
    protected $fillable = ['name'];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function subdepartments()
    {
        return $this->hasMany(Subdepartment::class);
    }
}
