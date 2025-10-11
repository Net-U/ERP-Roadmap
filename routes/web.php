<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\HarvestController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\EmployeeController;
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

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', RoleMiddleware::class . ':admin'])
    ->name('admin.')
    ->group(function () {
        // Dashboard admin
        Route::get('/', function () {
            return view('dashboard.dashboard');
        })->name('dashboard');

        // Import GeoJSON (fitur upload file)
        Route::get('/import-geojson', [BlokKebunImportController::class, 'index'])
            ->name('import-geojson');
        Route::post('/import-geojson', [BlokKebunImportController::class, 'store'])
            ->name('import-geojson.store');

        // 📍 Manajemen Pegawai
        Route::get('/dashboard/employees', [EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/dashboard/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
        Route::get('/employees/import', [EmployeeController::class, 'showImportForm'])->name('employees.import');
        Route::post('/employees/import', [EmployeeController::class, 'import'])->name('employees.import.store');
        Route::get('/employees/export-full', [EmployeeController::class, 'exportFull'])->name('employees.exportFull');
        Route::get('/employees/{employee}/export-word', [EmployeeController::class, 'exportWord'])->name('employees.exportWord');
        Route::get('/register/update/{id}', [EmployeeController::class, 'editCustom'])->name('employees.editCustom');
        Route::resource('employees', EmployeeController::class);

        // 📍 Akun & Registrasi
        Route::get('/dashboard/register', [RegisterController::class, 'create'])->name('register.form');
        Route::post('/dashboard/register', [RegisterController::class, 'store'])->name('register.store');

        Route::get('/dashboard/accounts/create', [AccountController::class, 'create'])->name('accounts.create');
        Route::post('/dashboard/accounts/store', [AccountController::class, 'store'])->name('accounts.store');

        // Menyimpan data update
        Route::put('/admin/employees/{id}', [RegisterController::class, 'update'])->name('employees.update');

        Route::get('/harvest/create', [HarvestController::class, 'create'])->name('harvest.create');
        Route::post('/harvest/store', [HarvestController::class, 'store'])->name('harvest.store');


    });

/*
|--------------------------------------------------------------------------
| Manager Routes
|--------------------------------------------------------------------------
*/
Route::prefix('manager')
    ->middleware(['auth', RoleMiddleware::class . ':manager'])
    ->name('manager.')
    ->group(function () {
        Route::get('/', function () {
            return view('dashboard.manager'); // buat file resources/views/dashboard/manager.blade.php
        })->name('dashboard');
    });

/*
|--------------------------------------------------------------------------
| Admin + Manager Shared Routes
|--------------------------------------------------------------------------
*/
Route::prefix('management')
    ->middleware(['auth', RoleMiddleware::class . ':admin,manager'])
    ->name('management.')
    ->group(function () {
        Route::get('/reports', function () {
            return "Halaman Laporan (bisa diakses admin & manager)";
        })->name('reports');
    });

/*
|--------------------------------------------------------------------------
| Optional Example API
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
