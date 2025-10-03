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

        $features = BlokKebun::all()->map(function($blok) use ($today) {
            $hari_jalan = $today->diffInDays(Carbon::parse($blok->tgl_panen_terakhir));
            
            // Logika status
            if ($hari_jalan < $blok->rotasi_panen * 0.5) {
                $status = "hijau";
            } elseif ($hari_jalan < $blok->rotasi_panen) {
                $status = "kuning";
            } else {
                $status = "merah";
            }

            return [
                "type" => "Feature",
                "geometry" => json_decode($blok->geom),
                "properties" => [
                    "kode" => $blok->kode_blok,
                    "luas" => $blok->luas_ha,
                    "status" => $status
                ]
            ];
        });

        return response()->json([
            "type" => "FeatureCollection",
            "features" => $features
        ]);
    }
}
