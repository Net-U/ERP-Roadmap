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
        'geom' => 'array', // otomatis decode JSON ke array
    ];
}
