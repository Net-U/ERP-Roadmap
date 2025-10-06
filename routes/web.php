<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\BlokKebunImportController;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

// halaman login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// proses login
Route::post('/login', [LoginController::class, 'login'])->name('login.process');

// logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/

// dashboard umum (hanya login, role user biasa)
Route::get('/', function () {
    return view('dashboard.dashboard'); // file: resources/views/dashboard/dashboard.blade.php
})->middleware(['auth', RoleMiddleware::class . ':user,admin'])->name('dashboard');

// admin only
Route::prefix('admin')
    ->middleware(['auth', RoleMiddleware::class . ':admin'])
    ->name('admin.') // ⬅️ ini penting
    ->group(function () {
        Route::get('/', function () {
            return view('dashboard.dashboard');
        })->name('dashboard');

        Route::get('import-geojson', [BlokKebunImportController::class, 'index'])->name('import.geojson');
        Route::post('import-geojson', [BlokKebunImportController::class, 'store'])->name('import.geojson.store');
    });


// manager only
Route::prefix('manager')
    ->middleware(['auth', RoleMiddleware::class . ':manager'])
    ->group(function () {
        Route::get('/', function () {
            return view('dashboard.manager'); // bikin file resources/views/dashboard/manager.blade.php
        })->name('manager.dashboard');
    });

// admin atau manager
Route::prefix('management')
    ->middleware(['auth', RoleMiddleware::class . ':admin,manager'])
    ->group(function () {
        Route::get('/reports', function () {
            return "Halaman Laporan (bisa diakses admin & manager)";
        })->name('management.reports');
    });

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


/*
|--------------------------------------------------------------------------
| Contoh API (opsional)
|--------------------------------------------------------------------------
*/
// Route::get('/api/blok', function () {
//     return response()->json([
//         'type' => 'FeatureCollection',
//         'features' => [
//             [
//                 'type' => 'Feature',
//                 'properties' => [
//                     'kode' => 'A1',
//                     'status' => 'hijau',
//                     'luas' => 10,
//                 ],
//                 'geometry' => [
//                     'type' => 'Polygon',
//                     'coordinates' => [
//                         [
//                             [112.010, -2.092],
//                             [112.012, -2.092],
//                             [112.012, -2.094],
//                             [112.010, -2.094],
//                             [112.010, -2.092],
//                         ],
//                     ],
//                 ],
//             ],
//         ],
//     ]);
// });
