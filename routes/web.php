<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard.dashboard');
});

Route::get('/api/blok', function () {
    return response()->json([
        'type' => 'FeatureCollection',
        'features' => [
            [
                'type' => 'Feature',
                'properties' => [
                    'kode' => 'A1',
                    'status' => 'hijau',
                    'luas' => 10,
                ],
                'geometry' => [
                    'type' => 'Polygon',
                    'coordinates' => [
                        [
                            [112.010, -2.092],
                            [112.012, -2.092],
                            [112.012, -2.094],
                            [112.010, -2.094],
                            [112.010, -2.092],
                        ],
                    ],
                ],
            ],
        ],
    ]);
});
