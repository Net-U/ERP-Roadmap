<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\HarvestController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\BlokKebunController;
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
    return view('dashboard.dashboard');
})->middleware(['auth', RoleMiddleware::class . ':user,admin,manager'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', RoleMiddleware::class . ':admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/', fn() => view('dashboard.dashboard'))->name('dashboard');

        // 📁 Import GeoJSON
        Route::get('/import-geojson', [BlokKebunImportController::class, 'index'])->name('import-geojson');
        Route::post('/import-geojson', [BlokKebunImportController::class, 'store'])->name('import-geojson.store');

        // 📁 Manajemen Pegawai
        Route::get('/dashboard/employees', [EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/dashboard/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
        Route::get('/employees/import', [EmployeeController::class, 'showImportForm'])->name('employees.import');
        Route::post('/employees/import', [EmployeeController::class, 'import'])->name('employees.import.store');
        Route::get('/employees/export-full', [EmployeeController::class, 'exportFull'])->name('employees.exportFull');
        Route::get('/employees/{employee}/export-word', [EmployeeController::class, 'exportWord'])->name('employees.exportWord');
        Route::get('/register/update/{id}', [EmployeeController::class, 'editCustom'])->name('employees.editCustom');
        Route::resource('employees', EmployeeController::class);

        // 📁 Akun & Registrasi
        Route::get('/dashboard/register', [RegisterController::class, 'create'])->name('register.form');
        Route::post('/dashboard/register', [RegisterController::class, 'store'])->name('register.store');
        Route::get('/dashboard/accounts/create', [AccountController::class, 'create'])->name('accounts.create');
        Route::post('/dashboard/accounts/store', [AccountController::class, 'store'])->name('accounts.store');

        // 📁 Data Panen
        Route::get('/harvest', [HarvestController::class, 'index'])->name('harvest.index');        
        Route::get('/harvest/create', [HarvestController::class, 'create'])->name('harvest.create');
        Route::post('/harvest/store', [HarvestController::class, 'store'])->name('harvest.store');

        // 📁 Blok Kebun
        Route::get('/blok-kebun/update-laporan', [BlokKebunController::class, 'editLaporan'])->name('blok-kebun.update-laporan');
        Route::post('/blok-kebun/update-laporan', [BlokKebunController::class, 'updateLaporan'])->name('blok-kebun.update-laporan');
        Route::get('/blok-kebun/{id}/detail', [BlokKebunController::class, 'getDetail'])->name('blok-kebun.detail');
        Route::get('/blok-kebun/blokWajibPanen', [BlokKebunController::class, 'blokWajibPanen'])->name('blok-kebun.laporan');
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
        Route::get('/', fn() => view('dashboard.manager'))->name('dashboard');
    });

/*
|--------------------------------------------------------------------------
| Shared Routes (Admin + Manager)
|--------------------------------------------------------------------------
*/
Route::prefix('management')
    ->middleware(['auth', RoleMiddleware::class . ':admin,manager'])
    ->name('management.')
    ->group(function () {
        Route::get('/reports', fn() => "Halaman Laporan (bisa diakses admin & manager)")->name('reports');
    });

/*
|--------------------------------------------------------------------------
| Statistik Panen (Global Access untuk Dashboard)
|--------------------------------------------------------------------------
*/
Route::get('/harvest/stats', [HarvestController::class, 'getStats'])
    ->middleware('auth')
    ->name('harvest.stats');
