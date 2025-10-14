<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlokKebun;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BlokKebunController extends Controller
{
        public function editLaporan()
    {
        $blokKebun = \App\Models\BlokKebun::all();
        return view('blok-kebun.update-laporan', compact('blokKebun'));
    }

    public function updateLaporan(Request $request)
    {
        $request->validate([
            'blok_kebun_id' => 'required|exists:blok_kebun,id',
            'tgl_panen_terakhir' => 'required|date',
            'rotasi_panen' => 'required|integer|min:1',
        ]);

        $blok = \App\Models\BlokKebun::findOrFail($request->blok_kebun_id);
        $blok->update([
            'tgl_panen_terakhir' => $request->tgl_panen_terakhir,
            'rotasi_panen' => $request->rotasi_panen,
        ]);

        return redirect()->back()->with('success', 'Laporan rotasi panen berhasil diperbarui!');
    }

    public function index()
    {
        $today = Carbon::now();

        $features = BlokKebun::all()->map(function ($blok) use ($today) {
            $hari_jalan = $today->diffInDays(Carbon::parse($blok->tgl_panen_terakhir));

            // Tentukan status berdasarkan rotasi panen (7 hari = 1 siklus)
            if ($hari_jalan === 0) {
                $status = "biru"; // sedang panen hari ini
            } elseif ($hari_jalan <= 3) {
                $status = "hijau"; // baru selesai panen
            } elseif ($hari_jalan <= 6) {
                $status = "kuning"; // 4–6 hari setelah panen
            } else {
                $status = "merah"; // ≥7 hari sejak panen terakhir
            }

            return [
                "type" => "Feature",
                "geometry" => $blok->geom, // hasil decode otomatis dari model
                "properties" => [
                    "id" => $blok->id,
                    "kode_blok" => $blok->kode_blok,
                    "luas_ha" => $blok->luas_ha,
                    "rotasi_panen" => $blok->rotasi_panen,
                    "tgl_panen_terakhir" => $blok->tgl_panen_terakhir->format('Y-m-d'),
                    "status" => $status,
                ],
            ];
        });

        return response()->json([
            "type" => "FeatureCollection",
            "features" => $features,
        ]);

        
    }

public function getDetail($id)
{
    $blok = \App\Models\BlokKebun::findOrFail($id);
    $hariSejakPanen = round(now()->diffInDays(\Carbon\Carbon::parse($blok->tgl_panen_terakhir)));

    return response()->json([
        'tgl_panen_terakhir' => $blok->tgl_panen_terakhir->format('Y-m-d'),
        'rotasi_panen' => $blok->rotasi_panen,
        'hari_sejak_panen' => $hariSejakPanen,
    ]);
}


public function blokWajibPanen()
{
    $today = \Carbon\Carbon::today();

    $blokKebun = BlokKebun::all()
        ->filter(function ($blok) use ($today) {
            if (!$blok->tgl_panen_terakhir) return false;

            $tglPanen = \Carbon\Carbon::parse($blok->tgl_panen_terakhir);

            // Hanya ambil blok yang sudah lewat dari tanggal panen terakhir
            if ($tglPanen->greaterThan($today)) {
                return false; // skip kalau tanggal panen terakhir di masa depan
            }

            $hariSejakPanen = $tglPanen->diffInDays($today);

            return $hariSejakPanen >= 6; // ambil blok >= 6 hari sejak panen terakhir
        })
        ->map(function ($blok) use ($today) {
            $tglPanen = \Carbon\Carbon::parse($blok->tgl_panen_terakhir);
            $hariSejakPanen = $tglPanen->diffInDays($today);

            return [
                'kode_blok' => $blok->kode_blok,
                'luas_ha' => $blok->luas_ha,
                'tgl_panen_terakhir' => $tglPanen->format('d/m/Y'),
                'hari_sejak_panen' => $hariSejakPanen,
                'rotasi_panen' => $blok->rotasi_panen,
            ];
        });

    return view('blok-kebun.laporan', compact('blokKebun'));
}

    
}
