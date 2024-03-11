<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\ReportController;


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

    Route::get('/export-karyawan', [KaryawanController::class, 'export'])->name('export-karyawan');

    // Route Departemen
    Route::resource('departemen', DepartemenController::class)->parameters([
        'departemen' => 'id_departemen',
    ]);

    // Route Jabatan
    Route::resource('jabatan', JabatanController::class)->parameters([
        'jabatan' => 'id_jabatan',
    ]);
    
    //Route Profil
    Route::get('/profil', [KaryawanController::class, 'show_profil']);
    Route::post('/profil/save/{id_karyawan}', [KaryawanController::class, 'update_profil']);
    
    // Route Absensi
    Route::get('/absensi/surat_absensi/{nip}', [AbsensiController::class, 'print_surat_absensi']);
    Route::resource('absensi', AbsensiController::class)->parameters([
        'absensi' => 'id_absensi',
    ]);

    Route::get('/export-absensi', [AbsensiController::class, 'export'])->name('export-absensi');

    Route::get('/absensi/persetujuan_hr/{id_absen}', [AbsensiController::class, 'persetujuan_hr']);
    Route::get('/absensi/penolakan_hr/{id_absen}', [AbsensiController::class, 'penolakan_hr']);

    Route::get('/absensi/persetujuan_atasan/{id_absen}', [AbsensiController::class, 'persetujuan_atasan']);
    Route::get('/absensi/penolakan_atasan/{id_absen}', [AbsensiController::class, 'penolakan_atasan']);

    Route::get('/ubah-jumlah-cuti', [AbsensiController::class,'showFormUbahJumlahCuti'])->name('ubah-jumlah-cuti');
    Route::post('/update-jumlah-cuti', [AbsensiController::class,'updateJumlahCuti'])->name('update-jumlah-cuti');
    
    // Route Overtime
    Route::get('/overtime/surat_overtime/{id_ovt}', [OvertimeController::class, 'print_surat_overtime']);

    Route::resource('overtime', OvertimeController::class)->parameters([
        'overtime' => 'id_ovt',
    ]);

    Route::get('/export-overtime', [OvertimeController::class, 'export'])->name('export-overtime');


    Route::get('/overtime/persetujuan_hr/{id_ovt}', [OvertimeController::class, 'persetujuan_hr']);
    Route::get('/overtime/penolakan_hr/{id_ovt}', [OvertimeController::class, 'penolakan_hr']);

    Route::get('/overtime/persetujuan_atasan/{id_ovt}', [OvertimeController::class, 'persetujuan_atasan']);
    Route::get('/overtime/penolakan_atasan/{id_ovt}', [OvertimeController::class, 'penolakan_atasan']);

    // Route Report
    Route::get('/report', [ReportController::class, 'index']);
    Route::post('/report/absensi/tanggal', [ReportController::class, 'rpt_absensi_tanggal']);
    Route::post('/report/overtime/tanggal', [ReportController::class, 'rpt_overtime_tanggal']);
    Route::get('/report/absensi', [ReportController::class, 'rpt_absensi']);
    Route::get('/report/overtime', [ReportController::class, 'rpt_overtime']);

    // Route Export Excel Report
    Route::get('/export-absensi-all', [ReportController::class, 'export_absensi_all'])->name('export_absensi_all');
    Route::get('/export-absensi-pertanggal', [ReportController::class, 'export_absensi_pertanggal'])->name('export_absensi_pertanggal');
    Route::get('/export-overtime-all', [ReportController::class, 'export_overtime_all'])->name('export_overtime_all');
    Route::get('/export-overtime-pertanggal', [ReportController::class, 'export_overtime_pertanggal'])->name('export_overtime_pertanggal');

    // Route Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});