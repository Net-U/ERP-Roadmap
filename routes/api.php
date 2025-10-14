<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
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

/**
 * ✅ Fungsi bantu untuk membaca file GeoJSON dari storage
 */
function fetchGeoJSONFromStorage()
{
    $path = 'public/blok_kebun.geojson'; // Lokasi file di storage/app/public

    if (!Storage::exists($path)) {
        return response()->json(['error' => 'File GeoJSON tidak ditemukan.'], 404);
    }

    $geojsonContent = Storage::get($path);
    return json_decode($geojsonContent, true);
}

/**
 * ✅ Endpoint utama untuk menampilkan data blok kebun
 * Jika data di database ada → pakai database
 * Jika kosong → fallback ke file GeoJSON di storage
 */
Route::get('/blok-kebun', function () {
    $blokKebun = BlokKebun::all();

    if ($blokKebun->isEmpty()) {
        // 🔁 Jika database kosong, ambil dari file GeoJSON di storage
        $geojson = fetchGeoJSONFromStorage();
        return response()->json($geojson);
    }

    // 🔹 Jika database berisi data, kirim dalam format GeoJSON
    $features = $blokKebun->map(function ($blok) {
        return [
            'type' => 'Feature',
            'properties' => [
                'id' => $blok->id,
                'kode_blok' => $blok->kode_blok,
                'luas_ha' => $blok->luas_ha,
                'rotasi_panen' => $blok->rotasi_panen,
                'tgl_panen_terakhir' => optional($blok->tgl_panen_terakhir)->format('Y-m-d'),
            ],
            'geometry' => is_string($blok->geom)
                ? json_decode($blok->geom, true)
                : $blok->geom,
        ];
    });

    return response()->json([
        'type' => 'FeatureCollection',
        'features' => $features,
    ]);
});
