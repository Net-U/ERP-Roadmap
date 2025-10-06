<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BlokKebunController;

Route::get('/blok', [BlokKebunController::class, 'index']);
