<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlokKebun;
use Carbon\Carbon;

class BlokKebunController extends Controller
{
    public function index()
    {
        $today = Carbon::now();

        $features = BlokKebun::all()->map(function ($blok) use ($today) {
            $hari_jalan = $today->diffInDays(Carbon::parse($blok->tgl_panen_terakhir));

            // Tentukan status berdasarkan rotasi
            if ($hari_jalan < $blok->rotasi_panen * 0.5) {
                $status = "hijau";
            } elseif ($hari_jalan < $blok->rotasi_panen) {
                $status = "kuning";
            } else {
                $status = "merah";
            }

            return [
                "type" => "Feature",
                "geometry" => $blok->geom, // Sudah array hasil json_decode otomatis dari model
                "properties" => [
                    "id" => $blok->id,
                    "kode_blok" => $blok->kode_blok,
                    "luas_ha" => $blok->luas_ha,
                    "rotasi_panen" => $blok->rotasi_panen,
                    "tgl_panen_terakhir" => $blok->tgl_panen_terakhir->toDateString(),
                    "status" => $status,
                ],
            ];
        });

        return response()->json([
            "type" => "FeatureCollection",
            "features" => $features,
        ]);
    }
}
