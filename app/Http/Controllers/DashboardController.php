<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        
            // Jika pengguna adalah "Staff", hanya tampilkan data absensi dan overtime yang terkait dengan 'nip' mereka
            if ($user->divisi === 'Staff') {
                $absensi = Absensi::orderBy('tgl_absen','DESC')->where('nip', $user->nip)->get();
                $overtime = Overtime::orderBy('tgl_ovt','DESC')->where('nip', $user->nip)->get();
            }
        
            // Hitung jumlah karyawan, absensi, dan overtime sesuai dengan kondisi yang diterapkan
            $total_karyawan = Karyawan::where('nip', $user->nip)->count();
            $total_absensi = isset($absensi) ? count($absensi) : 0;
            $total_overtime = isset($overtime) ? count($overtime) : 0;
        }
        
        // Jika pengguna bukan "Staff", hitung total karyawan, absensi, dan overtime secara keseluruhan
        if ($user->divisi !== 'Staff') {
            $total_karyawan = Karyawan::count();
            $total_absensi = Absensi::count();
            $total_overtime = Overtime::count();
            $absensi  = Absensi::orderBy('tgl_absen','DESC')->get();
            $overtime = Overtime::orderBy('tgl_ovt','DESC')->get();

        }
        
        return view('dashboard', compact('total_karyawan', 'total_absensi', 'total_overtime', 'absensi', 'overtime'));
        
    }
    
}