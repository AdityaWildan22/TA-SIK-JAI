<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Overtime;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){

        if (auth()->check()) {
            $user = Auth::user();
    
            if ($user->role == 'Staff') {

                $absensi = DB::table('absensis')
                    ->join('departemens', 'absensis.id_departemen', '=', 'departemens.id_departemen')
                    ->select('absensis.*', 'departemens.nm_dept')
                    ->orderBy('tgl_absen', 'DESC')
                    ->where('nip', $user->nip)
                    ->get();
            
                $overtime = DB::table('overtimes')
                    ->join('departemens', 'overtimes.id_departemen', '=', 'departemens.id_departemen')
                    ->select('overtimes.*', 'departemens.nm_dept')
                    ->orderBy('tgl_ovt', 'DESC')
                    ->where('nip', $user->nip)
                    ->get();
                
                $total_karyawan = Karyawan::where('nip', $user->nip)->count();
                $total_absensi = isset($absensi) ? count($absensi) : 0;
                $total_overtime = isset($overtime) ? count($overtime) : 0;
            
                $total_cuti = DB::table('absensis')
                ->where('nip', $user->nip)
                ->where('jns_absen', 'Cuti')
                ->count();

                $sisa_cuti = env('BATAS_CUTI') - $total_cuti;
            
            } else if ($user->role == 'SPV' || $user->role == 'Manager') {
            
                $absensi = DB::table('absensis')
                    ->join('departemens', 'absensis.id_departemen', '=', 'departemens.id_departemen')
                    ->select('absensis.*', 'departemens.nm_dept')
                    ->orderBy('tgl_absen', 'DESC')
                    ->where('absensis.id_departemen', $user->id_departemen)
                    ->get();
            
                $overtime = DB::table('overtimes')
                    ->join('departemens', 'overtimes.id_departemen', '=', 'departemens.id_departemen')
                    ->select('overtimes.*', 'departemens.nm_dept')
                    ->orderBy('tgl_ovt', 'DESC')
                    ->where('overtimes.id_departemen', $user->id_departemen)
                    ->get();
                
                $total_karyawan = Karyawan::where('id_departemen', $user->id_departemen)->count();
                $total_absensi = isset($absensi) ? count($absensi) : 0;
                $total_overtime = isset($overtime) ? count($overtime) : 0;
            
                $total_cuti = DB::table('absensis')
                ->where('nip', $user->nip)
                ->where('jns_absen', 'Cuti')
                ->count();

                $sisa_cuti = env('BATAS_CUTI') - $total_cuti;
            
            } else {
            
                $total_karyawan = Karyawan::count();
                $total_absensi = Absensi::count();
                $total_overtime = Overtime::count();
                
                $absensi = DB::table('absensis')
                    ->join('departemens', 'absensis.id_departemen', '=', 'departemens.id_departemen')
                    ->select('absensis.*', 'departemens.nm_dept')
                    ->orderBy('tgl_absen', 'DESC')
                    ->get();
            
                $overtime = DB::table('overtimes')
                    ->join('departemens', 'overtimes.id_departemen', '=', 'departemens.id_departemen')
                    ->select('overtimes.*', 'departemens.nm_dept')
                    ->orderBy('tgl_ovt', 'DESC')
                    ->get();
            
                $total_cuti = DB::table('absensis')
                ->where('nip', $user->nip)
                ->where('jns_absen', 'Cuti')
                ->count();

                $sisa_cuti = env('BATAS_CUTI') - $total_cuti;
            }
            
        }
        return view('dashboard', compact('total_karyawan', 'total_absensi','sisa_cuti', 'total_overtime', 'absensi', 'overtime'));
        
    }
    
}