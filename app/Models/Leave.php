<?php

namespace App\Models;                      // ← namespace dulu

use Illuminate\Database\Eloquent\Model;   // ← import Model
use Carbon\Carbon;

class Leave extends Model
{
    protected $fillable = [
        'employee_id', 'start_date', 'end_date',
        'type', 'reason', 'status',
    ];

    /* optional: agar $leave->ui_status otomatis ikut toArray()/JSON */
    protected $appends = ['ui_status'];

    /* =========================
       | Relasi ke tabel employee
       ========================= */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /* =========================
       |  Accessor status dinamis
       ========================= */
    public function getUiStatusAttribute(): string
    {
        if ($this->status === 'pending')  return 'Pending';
        if ($this->status === 'rejected') return 'Rejected';

        $today = Carbon::today();
        $start = Carbon::parse($this->start_date);
        $end   = Carbon::parse($this->end_date);

        if ($today->lt($start))            return 'On Going';
        if ($today->between($start, $end)) return 'Dijalankan';

        return 'Selesai';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
