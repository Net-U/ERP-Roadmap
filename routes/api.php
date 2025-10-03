<?php

use Illuminate\Support\Facades\Route;

Route::get('/blok', function () {
    return response()->json([
        'message' => 'API blok jalan'
    ]);
});
