<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\BlokKebun;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ✅ Contoh endpoint bawaan Laravel Sanctum
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ✅ Endpoint utama untuk menampilkan data blok kebun dari database
Route::get('/blok-kebun', function () {
    $blokKebun = BlokKebun::all();

    $features = $blokKebun->map(function ($blok) {
        return [
            'type' => 'Feature',
            'properties' => [
                'id' => $blok->id,
                'kode_blok' => $blok->kode_blok,
                'luas_ha' => $blok->luas_ha,
                'rotasi_panen' => $blok->rotasi_panen,
                'tgl_panen_terakhir' => $blok->tgl_panen_terakhir->format('Y-m-d'),
            ],
            'geometry' => $blok->geom, // langsung ambil JSON geometry dari kolom geom
        ];
    });

    return response()->json([
        'type' => 'FeatureCollection',
        'features' => $features,
    ]);
});
