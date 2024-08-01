<?php

namespace App\Http\Controllers;
use App\Exports\ReportAbsensiAllExport;
use App\Exports\ReportAbsensiPerTanggalExport;
use App\Exports\ReportOvertimeAllExport;
use App\Exports\ReportOvertimePerTanggalExport;
use App\Models\Absensi;
use App\Models\Departemen;
use App\Models\Karyawan;
use App\Models\Overtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class ReportController extends Controller
{
    public function index(){
        return view('report.data');
    }

    public function rpt_absensi(){
        
        $no = 1;
        
        if(Auth::user()->role == "SuperAdmin"){
            $absensi = DB::table('absensis')
            ->join('departemens', 'absensis.id_departemen', '=', 'departemens.id_departemen')
            ->join('karyawans', 'absensis.nip','=','karyawans.nip')
            ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
            ->select('absensis.*','karyawans.*', 'departemens.nm_dept','jabatans.nm_jabatan')
            ->selectRaw('
            COUNT(CASE WHEN jns_absen = "Sakit Dengan Surat Dokter" THEN 1 END) AS jumlah_SD,
            COUNT(CASE WHEN jns_absen = "Sakit Dengan Opname" THEN 1 END) AS jumlah_SO,
            COUNT(CASE WHEN jns_absen = "Sakit" THEN 1 END) AS jumlah_S,
            COUNT(CASE WHEN jns_absen = "Izin" THEN 1 END) AS jumlah_I,
            COUNT(CASE WHEN jns_absen = "Izin Khusus" THEN 1 END) AS jumlah_IK,
            COUNT(CASE WHEN jns_absen = "Cuti" THEN 1 END) AS jumlah_C,
            COUNT(CASE WHEN jns_absen = "Tanpa Keterangan" THEN 1 END) AS jumlah_TK,
            COUNT(CASE WHEN jns_absen = "Cuti Kelahiran/Keguguran" THEN 1 END) AS jumlah_CK,
            COUNT(CASE WHEN jns_absen = "Cuti Haid" THEN 1 END) AS jumlah_CH,
            COUNT(CASE WHEN jns_absen = "Izin Terlambat Datang" THEN 1 END) AS jumlah_ITD,
            COUNT(CASE WHEN jns_absen = "Izin Cepat Pulang" THEN 1 END) AS jumlah_ICP,
            COUNT(CASE WHEN jns_absen = "Izin Keluar Sementara" THEN 1 END) AS jumlah_IKS,
            COUNT(CASE WHEN jns_absen = "Dinas Luar" THEN 1 END) AS jumlah_DL,
            COUNT(CASE WHEN jns_absen = "Cuti Luar Tanggungan" THEN 1 END) AS jumlah_CLT,
            COUNT(*) AS total_absensi')
            ->where('status_pengajuan','Diterima')
            ->groupBy('absensis.nip')
            ->get();
        }else{
            $absensi = DB::table('absensis')
            ->join('departemens', 'absensis.id_departemen', '=', 'departemens.id_departemen')
            ->join('karyawans', 'absensis.nip','=','karyawans.nip')
            ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
            ->select('absensis.*','karyawans.*', 'departemens.nm_dept','jabatans.nm_jabatan')
            ->selectRaw('
            COUNT(CASE WHEN jns_absen = "Sakit Dengan Surat Dokter" THEN 1 END) AS jumlah_SD,
            COUNT(CASE WHEN jns_absen = "Sakit Dengan Opname" THEN 1 END) AS jumlah_SO,
            COUNT(CASE WHEN jns_absen = "Sakit" THEN 1 END) AS jumlah_S,
            COUNT(CASE WHEN jns_absen = "Izin" THEN 1 END) AS jumlah_I,
            COUNT(CASE WHEN jns_absen = "Izin Khusus" THEN 1 END) AS jumlah_IK,
            COUNT(CASE WHEN jns_absen = "Cuti" THEN 1 END) AS jumlah_C,
            COUNT(CASE WHEN jns_absen = "Tanpa Keterangan" THEN 1 END) AS jumlah_TK,
            COUNT(CASE WHEN jns_absen = "Cuti Kelahiran/Keguguran" THEN 1 END) AS jumlah_CK,
            COUNT(CASE WHEN jns_absen = "Cuti Haid" THEN 1 END) AS jumlah_CH,
            COUNT(CASE WHEN jns_absen = "Izin Terlambat Datang" THEN 1 END) AS jumlah_ITD,
            COUNT(CASE WHEN jns_absen = "Izin Cepat Pulang" THEN 1 END) AS jumlah_ICP,
            COUNT(CASE WHEN jns_absen = "Izin Keluar Sementara" THEN 1 END) AS jumlah_IKS,
            COUNT(CASE WHEN jns_absen = "Dinas Luar" THEN 1 END) AS jumlah_DL,
            COUNT(CASE WHEN jns_absen = "Cuti Luar Tanggungan" THEN 1 END) AS jumlah_CLT,
            COUNT(*) AS total_absensi')
            ->where('status_pengajuan','Diterima')
            ->where('departemens.id_departemen',Auth::user()->id_departemen)
            ->groupBy('absensis.nip')
            ->get();
        }
        
        return view('report.report_absensi',compact('absensi','no'));
    }

    public function export_absensi_all()
    {
        return Excel::download(new ReportAbsensiAllExport, 'Laporan Semua Data Absensi.xlsx');
    }

    public function rpt_absensi_tanggal(Request $req){

        $tgl_awal = date("Y-m-d",strtotime($req->input("tgl_awal")));
        $tgl_akhir = date("Y-m-d",strtotime($req->input("tgl_akhir")));

        $no = 1;
        
        if(Auth::user()->role == "SuperAdmin"){
            $absensi = DB::table('absensis')
            ->join('departemens', 'absensis.id_departemen', '=', 'departemens.id_departemen')
            ->join('karyawans', 'absensis.nip','=','karyawans.nip')
            ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
            ->select('absensis.*','karyawans.*', 'departemens.nm_dept','jabatans.nm_jabatan')
            ->selectRaw('
            COUNT(CASE WHEN jns_absen = "Sakit Dengan Surat Dokter" THEN 1 END) AS jumlah_SD,
            COUNT(CASE WHEN jns_absen = "Sakit Dengan Opname" THEN 1 END) AS jumlah_SO,
            COUNT(CASE WHEN jns_absen = "Sakit" THEN 1 END) AS jumlah_S,
            COUNT(CASE WHEN jns_absen = "Izin" THEN 1 END) AS jumlah_I,
            COUNT(CASE WHEN jns_absen = "Izin Khusus" THEN 1 END) AS jumlah_IK,
            COUNT(CASE WHEN jns_absen = "Cuti" THEN 1 END) AS jumlah_C,
            COUNT(CASE WHEN jns_absen = "Tanpa Keterangan" THEN 1 END) AS jumlah_TK,
            COUNT(CASE WHEN jns_absen = "Cuti Kelahiran/Keguguran" THEN 1 END) AS jumlah_CK,
            COUNT(CASE WHEN jns_absen = "Cuti Haid" THEN 1 END) AS jumlah_CH,
            COUNT(CASE WHEN jns_absen = "Izin Terlambat Datang" THEN 1 END) AS jumlah_ITD,
            COUNT(CASE WHEN jns_absen = "Izin Cepat Pulang" THEN 1 END) AS jumlah_ICP,
            COUNT(CASE WHEN jns_absen = "Izin Keluar Sementara" THEN 1 END) AS jumlah_IKS,
            COUNT(CASE WHEN jns_absen = "Dinas Luar" THEN 1 END) AS jumlah_DL,
            COUNT(CASE WHEN jns_absen = "Cuti Luar Tanggungan" THEN 1 END) AS jumlah_CLT,
            COUNT(*) AS total_absensi')
            ->where(DB::raw("DATE_FORMAT(absensis.tgl_absen,'%Y-%m-%d')"),">=",$tgl_awal)
            ->where(DB::raw("DATE_FORMAT(absensis.tgl_absen,'%Y-%m-%d')"),"<=",$tgl_akhir)
            ->where('status_pengajuan','Diterima')
            ->groupBy('absensis.nip')
            ->get();
        }else{
            $absensi = DB::table('absensis')
            ->join('departemens', 'absensis.id_departemen', '=', 'departemens.id_departemen')
            ->join('karyawans', 'absensis.nip','=','karyawans.nip')
            ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
            ->select('absensis.*','karyawans.*', 'departemens.nm_dept','jabatans.nm_jabatan')
            ->selectRaw('
            COUNT(CASE WHEN jns_absen = "Sakit Dengan Surat Dokter" THEN 1 END) AS jumlah_SD,
            COUNT(CASE WHEN jns_absen = "Sakit Dengan Opname" THEN 1 END) AS jumlah_SO,
            COUNT(CASE WHEN jns_absen = "Sakit" THEN 1 END) AS jumlah_S,
            COUNT(CASE WHEN jns_absen = "Izin" THEN 1 END) AS jumlah_I,
            COUNT(CASE WHEN jns_absen = "Izin Khusus" THEN 1 END) AS jumlah_IK,
            COUNT(CASE WHEN jns_absen = "Cuti" THEN 1 END) AS jumlah_C,
            COUNT(CASE WHEN jns_absen = "Tanpa Keterangan" THEN 1 END) AS jumlah_TK,
            COUNT(CASE WHEN jns_absen = "Cuti Kelahiran/Keguguran" THEN 1 END) AS jumlah_CK,
            COUNT(CASE WHEN jns_absen = "Cuti Haid" THEN 1 END) AS jumlah_CH,
            COUNT(CASE WHEN jns_absen = "Izin Terlambat Datang" THEN 1 END) AS jumlah_ITD,
            COUNT(CASE WHEN jns_absen = "Izin Cepat Pulang" THEN 1 END) AS jumlah_ICP,
            COUNT(CASE WHEN jns_absen = "Izin Keluar Sementara" THEN 1 END) AS jumlah_IKS,
            COUNT(CASE WHEN jns_absen = "Dinas Luar" THEN 1 END) AS jumlah_DL,
            COUNT(CASE WHEN jns_absen = "Cuti Luar Tanggungan" THEN 1 END) AS jumlah_CLT,
            COUNT(*) AS total_absensi')
            ->where(DB::raw("DATE_FORMAT(absensis.tgl_absen,'%Y-%m-%d')"),">=",$tgl_awal)
            ->where(DB::raw("DATE_FORMAT(absensis.tgl_absen,'%Y-%m-%d')"),"<=",$tgl_akhir)
            ->where('status_pengajuan','Diterima')
            ->where('departemens.id_departemen',Auth::user()->id_departemen)
            ->groupBy('absensis.nip')
            ->get();
        }

        if (!$req->filled('tgl_awal') || !$req->filled('tgl_akhir')) {
            return redirect()->back()->with('error', 'MASUKKAN TANGGAL AWAL DAN TANGGAL AKHIR');
        }
        
        return view('report.report_absensi',compact('absensi','no','tgl_awal','tgl_akhir'));
    }

    public function export_absensi_pertanggal(Request $request){
        
        $tgl_awal_input = $request->input("tgl_awal");
        $tgl_akhir_input = $request->input("tgl_akhir");

        $tgl_awal = date("Y-m-d", strtotime($tgl_awal_input));
        $tgl_akhir = date("Y-m-d", strtotime($tgl_akhir_input));
    
        if (!$request->filled('tgl_awal') || !$request->filled('tgl_akhir')) {
            return redirect()->back()->with('error', 'MASUKKAN TANGGAL AWAL DAN TANGGAL AKHIR');
        }

        $absensi = Absensi::whereBetween('absensis.tgl_absen', [$tgl_awal, $tgl_akhir])
        ->get();
        
        if ($absensi->isEmpty()) {
            return redirect()->back()->with('error', 'DATA LAPORAN ABSENSI KOSONG');
        }

        $nama_file = 'Laporan Data Absensi Periode ' . date('d-m-Y', strtotime($tgl_awal)) . ' - ' . date('d-m-Y', strtotime($tgl_akhir)) . '.xlsx';
    
        return Excel::download(new ReportAbsensiPerTanggalExport($tgl_awal, $tgl_akhir), $nama_file);
    }

    public function rpt_overtime(){
        
        $no = 1;
        
        if(Auth::user()->role == "SuperAdmin"){
            $overtime = DB::table('overtimes')
            ->join('departemens', 'overtimes.id_departemen', '=', 'departemens.id_departemen')
            ->join('karyawans', 'overtimes.nip','=','karyawans.nip')
            ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
            ->select('overtimes.*','karyawans.*', 'departemens.nm_dept','jabatans.nm_jabatan')
            ->selectRaw('COUNT(*) AS total_overtime')
            ->where('status_pengajuan','Diterima')
            ->groupBy('overtimes.nip')
            ->get();
        }else{
            $overtime = DB::table('overtimes')
            ->join('departemens', 'overtimes.id_departemen', '=', 'departemens.id_departemen')
            ->join('karyawans', 'overtimes.nip','=','karyawans.nip')
            ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
            ->select('overtimes.*','karyawans.*', 'departemens.nm_dept','jabatans.nm_jabatan')
            ->selectRaw('COUNT(*) AS total_overtime')
            ->where('status_pengajuan','Diterima')
            ->where('departemens.id_departemen',Auth::user()->id_departemen)
            ->groupBy('overtimes.nip')
            ->get();
        }
        
        return view('report.report_overtime',compact('overtime','no'));
    }

    public function export_overtime_all()
    {
        return Excel::download(new ReportOvertimeAllExport, 'Laporan Semua Data Overtime.xlsx');
    }

    public function rpt_overtime_tanggal(Request $req){

        $tgl_awal = date("Y-m-d",strtotime($req->input("tgl_awal")));
        $tgl_akhir = date("Y-m-d",strtotime($req->input("tgl_akhir")));
        
        $no = 1;
        
        if(Auth::user()->role == "SuperAdmin"){
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
        }else{
            $overtime = DB::table('overtimes')
            ->join('departemens', 'overtimes.id_departemen', '=', 'departemens.id_departemen')
            ->join('karyawans', 'overtimes.nip','=','karyawans.nip')
            ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
            ->select('overtimes.*','karyawans.*', 'departemens.nm_dept','jabatans.nm_jabatan')
            ->selectRaw('COUNT(*) AS total_overtime')
            ->where(DB::raw("DATE_FORMAT(overtimes.tgl_ovt,'%Y-%m-%d')"),">=",$tgl_awal)
            ->where(DB::raw("DATE_FORMAT(overtimes.tgl_ovt,'%Y-%m-%d')"),"<=",$tgl_akhir)
            ->where('status_pengajuan','Diterima')
            ->where('departemens.id_departemen',Auth::user()->id_departemen)
            ->groupBy('overtimes.nip')
            ->get();
        }

        if (!$req->filled('tgl_awal') || !$req->filled('tgl_akhir')) {
            return redirect()->back()->with('error', 'MASUKKAN TANGGAL AWAL DAN TANGGAL AKHIR');
        }

        return view('report.report_overtime',compact('overtime','no','tgl_awal','tgl_akhir'));
    }

    public function export_overtime_pertanggal(Request $request){
        
        $tgl_awal_input = $request->input("tgl_awal");
        $tgl_akhir_input = $request->input("tgl_akhir");

        $tgl_awal = date("Y-m-d", strtotime($tgl_awal_input));
        $tgl_akhir = date("Y-m-d", strtotime($tgl_akhir_input));

        if (!$request->filled('tgl_awal') || !$request->filled('tgl_akhir')) {
            return redirect()->back()->with('error', 'MASUKKAN TANGGAL AWAL DAN TANGGAL AKHIR');
        }

        $overtime = Overtime::whereBetween('overtimes.tgl_ovt', [$tgl_awal, $tgl_akhir])
        ->get();
        
        if ($overtime->isEmpty()) {
            return redirect()->back()->with('error', 'DATA LAPORAN OVERTIME KOSONG');
        }

        $nama_file = 'Laporan Data Overtime Periode ' . date('d-m-Y', strtotime($tgl_awal)) . ' - ' . date('d-m-Y', strtotime($tgl_akhir)) . '.xlsx';
    
        return Excel::download(new ReportOvertimePerTanggalExport($tgl_awal, $tgl_akhir), $nama_file);
    }

}