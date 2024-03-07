<?php

namespace App\Http\Controllers;
use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(){
        return view('report.data');
    }

    public function rpt_absensi(){
        
        $no = 1;
        
        $absensi = DB::table('absensis')
        ->join('departemens', 'absensis.id_departemen', '=', 'departemens.id_departemen')
        ->join('karyawans', 'absensis.nip','=','karyawans.nip')
        ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
        ->select('absensis.*','karyawans.*', 'departemens.nm_dept','jabatans.nm_jabatan')
        ->selectRaw('
        COUNT(CASE WHEN jns_absen = "Sakit" THEN 1 END) AS jumlah_S,
        COUNT(CASE WHEN jns_absen = "Izin" THEN 1 END) AS jumlah_I,
        COUNT(CASE WHEN jns_absen = "Izin Khusus" THEN 1 END) AS jumlah_IK,
        COUNT(CASE WHEN jns_absen = "Cuti" THEN 1 END) AS jumlah_C,
        COUNT(CASE WHEN jns_absen = "Cuti Kehamilan" THEN 1 END) AS jumlah_CK,
        COUNT(CASE WHEN jns_absen = "Cuti Haid" THEN 1 END) AS jumlah_CH,
        COUNT(CASE WHEN jns_absen = "Izin Terlambat Datang" THEN 1 END) AS jumlah_ITD,
        COUNT(CASE WHEN jns_absen = "Izin Cepat Pulang" THEN 1 END) AS jumlah_ICP,
        COUNT(CASE WHEN jns_absen = "Izin Keluar Sementara" THEN 1 END) AS jumlah_IKS,
        COUNT(CASE WHEN jns_absen = "Dinas Luar" THEN 1 END) AS jumlah_DL,
        COUNT(*) AS total_absensi')
        ->where('status_pengajuan','Diterima')
        ->groupBy('absensis.nip')
        ->get();
        
        return view('report.report_absensi',compact('absensi','no'));
    }

    public function rpt_absensi_tanggal(Request $req){

        $tgl_awal = date("Y-m-d",strtotime($req->input("tgl_awal")));
        $tgl_akhir = date("Y-m-d",strtotime($req->input("tgl_akhir")));

        $no = 1;
        
        $absensi = DB::table('absensis')
        ->join('departemens', 'absensis.id_departemen', '=', 'departemens.id_departemen')
        ->join('karyawans', 'absensis.nip','=','karyawans.nip')
        ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
        ->select('absensis.*','karyawans.*', 'departemens.nm_dept','jabatans.nm_jabatan')
        ->selectRaw('
        COUNT(CASE WHEN jns_absen = "Sakit" THEN 1 END) AS jumlah_S,
        COUNT(CASE WHEN jns_absen = "Izin" THEN 1 END) AS jumlah_I,
        COUNT(CASE WHEN jns_absen = "Izin Khusus" THEN 1 END) AS jumlah_IK,
        COUNT(CASE WHEN jns_absen = "Cuti" THEN 1 END) AS jumlah_C,
        COUNT(CASE WHEN jns_absen = "Cuti Kehamilan" THEN 1 END) AS jumlah_CK,
        COUNT(CASE WHEN jns_absen = "Cuti Haid" THEN 1 END) AS jumlah_CH,
        COUNT(CASE WHEN jns_absen = "Izin Terlambat Datang" THEN 1 END) AS jumlah_ITD,
        COUNT(CASE WHEN jns_absen = "Izin Cepat Pulang" THEN 1 END) AS jumlah_ICP,
        COUNT(CASE WHEN jns_absen = "Izin Keluar Sementara" THEN 1 END) AS jumlah_IKS,
        COUNT(CASE WHEN jns_absen = "Dinas Luar" THEN 1 END) AS jumlah_DL,
        COUNT(*) AS total_absensi')
        ->where(DB::raw("DATE_FORMAT(absensis.tgl_absen,'%Y-%m-%d')"),">=",$tgl_awal)
        ->where(DB::raw("DATE_FORMAT(absensis.tgl_absen,'%Y-%m-%d')"),"<=",$tgl_akhir)
        ->where('status_pengajuan','Diterima')
        ->groupBy('absensis.nip')
        ->get();
        
        return view('report.report_absensi',compact('absensi','no','tgl_awal','tgl_akhir'));
    }

    public function rpt_overtime(){
        
        $no = 1;
        
        $overtime = DB::table('overtimes')
        ->join('departemens', 'overtimes.id_departemen', '=', 'departemens.id_departemen')
        ->join('karyawans', 'overtimes.nip','=','karyawans.nip')
        ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
        ->select('overtimes.*','karyawans.*', 'departemens.nm_dept','jabatans.nm_jabatan')
        ->selectRaw('COUNT(*) AS total_overtime')
        ->where('status_pengajuan','Diterima')
        ->groupBy('overtimes.nip')
        ->get();
        
        return view('report.report_overtime',compact('overtime','no'));
    }

    public function rpt_overtime_tanggal(Request $req){

        $tgl_awal = date("Y-m-d",strtotime($req->input("tgl_awal")));
        $tgl_akhir = date("Y-m-d",strtotime($req->input("tgl_akhir")));
        
        $no = 1;
        
        $overtime = DB::table('overtimes')
        ->join('departemens', 'overtimes.id_departemen', '=', 'departemens.id_departemen')
        ->join('karyawans', 'overtimes.nip','=','karyawans.nip')
        ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
        ->select('overtimes.*','karyawans.*', 'departemens.nm_dept','jabatans.nm_jabatan')
        ->selectRaw('COUNT(*) AS total_overtime')
        ->where(DB::raw("DATE_FORMAT(overtimes.tgl_ovt,'%Y-%m-%d')"),">=",$tgl_awal)
        ->where(DB::raw("DATE_FORMAT(overtimes.tgl_ovt,'%Y-%m-%d')"),"<=",$tgl_akhir)
        ->where('status_pengajuan','Diterima')
        ->groupBy('overtimes.nip')
        ->get();

        return view('report.report_overtime',compact('overtime','no','tgl_awal','tgl_akhir'));
    }
}