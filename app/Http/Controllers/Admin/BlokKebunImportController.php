<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlokKebun;

class BlokKebunImportController extends Controller
{
    public function index()
    {
        return view('admin.import-geojson'); // pastikan file blade ada
    }

    public function store(Request $request)
    {
        $request->validate([
            'geojson_file' => 'required|file|mimes:json,geojson',
        ]);

        $geojson = json_decode(file_get_contents($request->file('geojson_file')), true);

        if (!isset($geojson['features'])) {
            return back()->with('error', 'File GeoJSON tidak valid!');
        }

        foreach ($geojson['features'] as $feature) {
            BlokKebun::create([
                'kode_blok' => $feature['properties']['kode'] ?? 'BLK-' . uniqid(),
                'luas_ha' => $feature['properties']['luas'] ?? 0,
                'geom' => json_encode($feature['geometry']),
                'rotasi_panen' => $feature['properties']['rotasi'] ?? 14,
                'tgl_panen_terakhir' => $feature['properties']['tgl_panen_terakhir'] ?? now(),
            ]);
        }

        return redirect()->route('admin.import-geojson')->with('success', 'Data GeoJSON berhasil diimport!');
    }
}
