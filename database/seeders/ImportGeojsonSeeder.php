<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BlokKebun;

class ImportGeojsonSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan file geojson tersedia di folder public/geojson
        $path = public_path('a/erp11.geojson');

        if (!file_exists($path)) {
            $this->command->error("❌ File GeoJSON tidak ditemukan di: $path");
            return;
        }

        // Baca isi file GeoJSON
        $geojson = json_decode(file_get_contents($path), true);

        if (!isset($geojson['features'])) {
            $this->command->error("❌ File GeoJSON tidak valid!");
            return;
        }

        $this->command->info("✅ File GeoJSON terbaca, mulai import...");

        $count = 0;
        foreach ($geojson['features'] as $feature) {
            $props = $feature['properties'] ?? [];
            $geometry = json_encode($feature['geometry'] ?? []);

            BlokKebun::create([
                'kode_blok' => $props['Nama_Blok'] ?? 'Tanpa Nama',
                'luas_ha' => $props['luasana'] ?? 0,
                'rotasi_panen' => $props['rotasi_panen'] ?? 14,
                'tgl_panen_terakhir' => $props['tgl_panen_terakhir'] ?? now(),
                'geom' => $geometry,
            ]);

            $count++;
        }

        $this->command->info("✅ Berhasil import $count blok kebun dari GeoJSON.");
    }
}
