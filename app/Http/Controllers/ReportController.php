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
        
        $absensi = DB::table('absensis')
        ->join('departemens', 'absensis.id_departemen', '=', 'departemens.id_departemen')
        ->join('karyawans', 'absensis.nip','=','karyawans.nip')
        ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
        ->join('sections', 'karyawans.id_section', '=', 'sections.id_section')
        ->select('absensis.*','karyawans.*', 'departemens.nm_dept','jabatans.nm_jabatan','sections.nm_section')
        ->selectRaw('TIMEDIFF(absensis.jam_akhir, absensis.jam_awal) AS total_jam')
        ->where('status_pengajuan','Diterima')
        // ->groupBy('absensis.nip')
        ->get();
        return view('report.report_absensi',compact('absensi'));
    }

    public function export_absensi_all()
    {
        return Excel::download(new ReportAbsensiAllExport, 'Laporan Semua Data Absensi.xlsx');
    }

    public function rpt_absensi_tanggal(Request $req){

        $tgl_awal = date("Y-m-d",strtotime($req->input("tgl_awal")));
        $tgl_akhir = date("Y-m-d",strtotime($req->input("tgl_akhir")));

        $absensi = DB::table('absensis')
        ->join('departemens', 'absensis.id_departemen', '=', 'departemens.id_departemen')
        ->join('karyawans', 'absensis.nip','=','karyawans.nip')
        ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
        ->join('sections', 'karyawans.id_section', '=', 'sections.id_section')
        ->select('absensis.*','karyawans.*', 'departemens.nm_dept','jabatans.nm_jabatan','sections.nm_section')
        ->selectRaw('TIMEDIFF(absensis.jam_akhir, absensis.jam_awal) AS total_jam')
        ->where(DB::raw("DATE_FORMAT(absensis.tgl_absen,'%Y-%m-%d')"),">=",$tgl_awal)
        ->where(DB::raw("DATE_FORMAT(absensis.tgl_absen,'%Y-%m-%d')"),"<=",$tgl_akhir)
        ->where('status_pengajuan','Diterima')
        // ->groupBy('absensis.nip')
        ->get();

        if (!$req->filled('tgl_awal') || !$req->filled('tgl_akhir')) {
            $mess = ["type" => "error", "text" => "Masukkan Tanggal Awal dan Tanggal Akhir"];
            return redirect()->back()->with($mess);
        }
        
        return view('report.report_absensi',compact('absensi','tgl_awal','tgl_akhir'));
    }

    public function export_absensi_pertanggal(Request $request){
        
        $tgl_awal_input = $request->input("tgl_awal");
        $tgl_akhir_input = $request->input("tgl_akhir");

        $tgl_awal = date("Y-m-d", strtotime($tgl_awal_input));
        $tgl_akhir = date("Y-m-d", strtotime($tgl_akhir_input));
    
        if (!$request->filled('tgl_awal') || !$request->filled('tgl_akhir')) {
            $mess = ["type" => "error", "text" => "Masukkan Tanggal Awal dan Tanggal Akhir"];
            return redirect()->back()->with($mess);
        }

        $absensi = Absensi::whereBetween('absensis.tgl_absen', [$tgl_awal, $tgl_akhir])
        ->get();
        
        if ($absensi->isEmpty()) {
            $mess = ["type" => "error", "text" => "Laporan Data Absensi Kosong"];
            return redirect()->back()->with($mess);
        }

        $nama_file = 'Laporan Data Absensi Periode ' . date('d-m-Y', strtotime($tgl_awal)) . ' - ' . date('d-m-Y', strtotime($tgl_akhir)) . '.xlsx';
    
        return Excel::download(new ReportAbsensiPerTanggalExport($tgl_awal, $tgl_akhir), $nama_file);
    }

    public function rpt_overtime(){
        
        $overtime = DB::table('overtimes')
        ->join('departemens', 'overtimes.id_departemen', '=', 'departemens.id_departemen')
        ->join('karyawans', 'overtimes.nip','=','karyawans.nip')
        ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
        ->join('sections', 'karyawans.id_section', '=', 'sections.id_section')
        ->select('overtimes.nip','karyawans.nama', 'departemens.nm_dept','jabatans.nm_jabatan','sections.nm_section','overtimes.tgl_ovt','overtimes.jam_awal','overtimes.jam_akhir')
        ->selectRaw('TIMEDIFF(overtimes.jam_akhir, overtimes.jam_awal) AS total_jam')
        ->where('status_pengajuan','Diterima')
        ->get();
        return view('report.report_overtime',compact('overtime'));
    }

    public function export_overtime_all()
    {
        return Excel::download(new ReportOvertimeAllExport, 'Laporan Semua Data Overtime.xlsx');
    }

    public function rpt_overtime_tanggal(Request $req){

        $tgl_awal = date("Y-m-d",strtotime($req->input("tgl_awal")));
        $tgl_akhir = date("Y-m-d",strtotime($req->input("tgl_akhir")));

        $overtime = DB::table('overtimes')
        ->join('departemens', 'overtimes.id_departemen', '=', 'departemens.id_departemen')
        ->join('karyawans', 'overtimes.nip','=','karyawans.nip')
        ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
        ->join('sections', 'karyawans.id_section', '=', 'sections.id_section')
        ->select('overtimes.nip','karyawans.nama', 'departemens.nm_dept','jabatans.nm_jabatan','sections.nm_section','overtimes.tgl_ovt','overtimes.jam_awal','overtimes.jam_akhir')
        ->selectRaw('TIMEDIFF(overtimes.jam_akhir, overtimes.jam_awal) AS total_jam')
        ->where('status_pengajuan','Diterima')
        ->where(DB::raw("DATE_FORMAT(overtimes.tgl_ovt,'%Y-%m-%d')"),">=",$tgl_awal)
        ->where(DB::raw("DATE_FORMAT(overtimes.tgl_ovt,'%Y-%m-%d')"),"<=",$tgl_akhir)
        ->get();
         
        if (!$req->filled('tgl_awal') || !$req->filled('tgl_akhir')) {
            $mess = ["type" => "error", "text" => "Masukkan Tanggal Awal dan Tanggal Akhir"];
            return redirect()->back()->with($mess);
        }

        return view('report.report_overtime',compact('overtime','tgl_awal','tgl_akhir'));
    }

    public function export_overtime_pertanggal(Request $request){
        
        $tgl_awal_input = $request->input("tgl_awal");
        $tgl_akhir_input = $request->input("tgl_akhir");

        $tgl_awal = date("Y-m-d", strtotime($tgl_awal_input));
        $tgl_akhir = date("Y-m-d", strtotime($tgl_akhir_input));

        if (!$request->filled('tgl_awal') || !$request->filled('tgl_akhir')) {
            $mess = ["type" => "error", "text" => "Masukkan Tanggal Awal dan Tanggal Akhir"];
            return redirect()->back()->with($mess);
        }

        $overtime = Overtime::whereBetween('overtimes.tgl_ovt', [$tgl_awal, $tgl_akhir])
        ->get();
        
        if ($overtime->isEmpty()) {
            $mess = ["type" => "error", "text" => "Laporan Data Overtime Kosong"];
            return redirect()->back()->with($mess);
        }

        $nama_file = 'Laporan Data Overtime Periode ' . date('d-m-Y', strtotime($tgl_awal)) . ' - ' . date('d-m-Y', strtotime($tgl_akhir)) . '.xlsx';
    
        return Excel::download(new ReportOvertimePerTanggalExport($tgl_awal, $tgl_akhir), $nama_file);
    }

}