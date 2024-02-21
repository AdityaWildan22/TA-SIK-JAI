<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

  
    // Ruote untuk menampilkan halaman login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

    // Ruote untuk memproses login
    Route::post('/login', [LoginController::class, 'authenticate']);
    
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
    
    // Route Karyawan
    Route::resource('karyawan', KaryawanController::class)->parameters([
        'karyawan' => 'id_karyawan',
    ]);
    
    //Route Profil
    Route::get('/profil', [KaryawanController::class, 'show_profil']);
    Route::post('/profil/save/{id_karyawan}', [KaryawanController::class, 'update_profil']);
    
    // Route Absensi
    Route::get('/absensi/surat_absensi/{id_absen}', [AbsensiController::class, 'print_surat_absensi']);
    Route::resource('absensi', AbsensiController::class)->parameters([
        'absensi' => 'id_absensi',
    ]);
    Route::get('/absensi/persetujuan_hr/{id_absen}', [AbsensiController::class, 'persetujuan_hr']);
    Route::get('/absensi/penolakan_hr/{id_absen}', [AbsensiController::class, 'penolakan_hr']);
    Route::get('/absensi/persetujuan_atasan/{id_absen}', [AbsensiController::class, 'persetujuan_atasan']);
    Route::get('/absensi/penolakan_atasan/{id_absen}', [AbsensiController::class, 'penolakan_atasan']);
    
    // Route Overtime
    Route::get('/overtime/surat_overtime/{id_ovt}', [OvertimeController::class, 'print_surat_overtime']);
    Route::resource('overtime', OvertimeController::class)->parameters([
        'overtime' => 'id_ovt',
    ]);
    Route::get('/overtime/persetujuan_hr/{id_ovt}', [OvertimeController::class, 'persetujuan_hr']);
    Route::get('/overtime/penolakan_hr/{id_ovt}', [OvertimeController::class, 'penolakan_hr']);
    Route::get('/overtime/persetujuan_atasan/{id_ovt}', [OvertimeController::class, 'persetujuan_atasan']);
    Route::get('/overtime/penolakan_atasan/{id_ovt}', [OvertimeController::class, 'penolakan_atasan']);

    // Route untuk Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});