<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlokKebun extends Model
{
    protected $table = 'blok_kebun';

    protected $fillable = [
        'kode_blok',
        'luas_ha',
        'geom',
        'rotasi_panen',
        'tgl_panen_terakhir',
    ];

    protected $casts = [
        'tgl_panen_terakhir' => 'date',
    ];

    // Auto-decode JSON string ke array saat diambil
    public function getGeomAttribute($value)
    {
        return json_decode($value, true);
    }

    // Auto-encode array ke JSON string saat disimpan
    public function setGeomAttribute($value)
    {
        $this->attributes['geom'] = is_array($value)
            ? json_encode($value)
            : $value;
    }
}
