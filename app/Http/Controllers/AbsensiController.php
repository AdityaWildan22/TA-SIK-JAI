<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\Section;
use App\Models\Karyawan;
use App\Models\Departemen;
use Illuminate\Http\Request;
use App\Exports\AbsensiExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Controller\KaryawanController;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreAbsensiRequest;
use App\Http\Requests\UpdateAbsensiRequest;

class AbsensiController extends Controller
{
    protected $view = 'absen.';
    protected $route = '/absensi/';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $absensi = DB::table('absensis')
            ->join('departemens','absensis.id_departemen','=','departemens.id_departemen')
            ->join('karyawans','absensis.nip','=','karyawans.nip')
            ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
            ->select('absensis.*','karyawans.*','departemens.nm_dept','jabatans.nm_jabatan');
        
            // Jika pengguna adalah "Staff", hanya tampilkan data absensi yang terkait dengan 'nip' mereka
            if ($user->role == 'Staff') {
                $absensi->where('absensis.nip', $user->nip);
            }else if($user->role == 'SPV' || $user->role == 'Manager'){
                $absensi->where('absensis.id_departemen',$user->id_departemen);
            }
                    
            $absensi = $absensi->get();
        
            $routes = (object) [
                'index' => $this->route,
                'add' => $this->route . 'create',
            ];
        
            return view($this->view . 'data', compact('routes', 'absensi'));
        } else {
            $absensi = $absensi->get();
        }
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $routes =(object)[
            'index'=> $this->route,
            'save' => $this->route,
            'is_update'=>false,
        ];

        $spv = DB::table('karyawans')
        ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
        ->join('departemens','karyawans.id_departemen','=','departemens.id_departemen')
        ->select('karyawans.*','jabatans.nm_jabatan','departemens.*')
        ->where('nm_jabatan','SPV')
        ->where('karyawans.id_departemen',Auth::user()->id_departemen)
        ->get();

        $manager = DB::table('karyawans')
        ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
        ->join('departemens','karyawans.id_departemen','=','departemens.id_departemen')
        ->select('karyawans.*','jabatans.nm_jabatan','departemens.*')
        ->where('nm_jabatan','Manager')
        ->where('karyawans.id_departemen',Auth::user()->id_departemen)
        ->get();

        $hr = DB::table('karyawans')
        ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
        ->join('departemens','karyawans.id_departemen','=','departemens.id_departemen')
        ->select('karyawans.*','jabatans.nm_jabatan','departemens.*')
        ->where('nm_jabatan','HR')
        ->where('karyawans.id_departemen',Auth::user()->id_departemen)
        ->get();
        
        $departemen = Departemen::All();
        $section = Section::All();

        return view($this->view.'form',compact('routes','spv','manager','hr','departemen','section'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAbsensiRequest $request)
    {
        // dd($request->all());
        $jumlahCuti = 0;
        $batasCuti = env('BATAS_CUTI');

        if ($request->jns_absen == 'Cuti') {
            $tahunIni = date('Y');
            $jumlahCuti = Absensi::where('nip', $request->nip)
                ->where('jns_absen', 'Cuti')
                ->whereYear('tgl_absen', $tahunIni)
                ->count();
            if ($jumlahCuti >= $batasCuti) {
                return redirect()->back()->with('error', 'JUMLAH CUTI ANDA TELAH HABIS');
            }
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('public/lampiran_foto');
            $filePath = Storage::url($path);
            $request["foto"] = $filePath;
        }
    
        $request["status_pengajuan"] = "Diproses";
        
        if ($jumlahCuti < $batasCuti) {
            Absensi::create($request->all());
            return redirect($this->route)->with('success', 'DATA BERHASIL DISIMPAN');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Absensi $absensi, $id_absen)
    {
        $absensi = Absensi::find($id_absen)
        ->join('departemens', 'absensis.id_departemen', '=', 'departemens.id_departemen')
        ->join('karyawans', 'absensis.nip', '=', 'karyawans.nip')
        ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
        ->select('absensis.*', 'departemens.nm_dept','jabatans.nm_jabatan')
        ->where('absensis.id_absen',$id_absen)
        ->first();

        $spv = DB::table('absensis')
        ->join('karyawans','absensis.id_spv','=','karyawans.nip')
        ->select('karyawans.nama')
        ->where('karyawans.nip',$absensi->id_spv)
        ->first();

        $manager = DB::table('absensis')
        ->join('karyawans','absensis.id_manager','=','karyawans.nip')
        ->select('karyawans.nama')
        ->where('karyawans.nip',$absensi->id_manager)
        ->first();

        $hr = DB::table('absensis')
        ->join('karyawans','absensis.id_hr','=','karyawans.nip')
        ->select('karyawans.nama')
        ->where('karyawans.nip',$absensi->id_hr)
        ->first();

        // dd($absensi->id_spv);
        return view($this->view . 'show', compact('absensi','manager','spv','hr'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Absensi $absensi, $id_absen)
    {
        $absensi = Absensi::where('id_absen', $id_absen)->first();
        $routes = (object)[
            'index' => $this->route,
            'save' => $this->route . $absensi->id_absen,
            'is_update' => true,
        ];

        $spv = DB::table('karyawans')
        ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
        ->join('departemens','karyawans.id_departemen','=','departemens.id_departemen')
        ->select('karyawans.*','jabatans.nm_jabatan','departemens.*')
        ->where('nm_jabatan','SPV')
        ->where('karyawans.id_departemen',Auth::user()->id_departemen)
        ->get();

        $manager = DB::table('karyawans')
        ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
        ->join('departemens','karyawans.id_departemen','=','departemens.id_departemen')
        ->select('karyawans.*','jabatans.nm_jabatan','departemens.*')
        ->where('nm_jabatan','Manager')
        ->where('karyawans.id_departemen',Auth::user()->id_departemen)
        ->get();

        $hr = DB::table('karyawans')
        ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
        ->join('departemens','karyawans.id_departemen','=','departemens.id_departemen')
        ->select('karyawans.*','jabatans.nm_jabatan','departemens.*')
        ->where('nm_jabatan','HR')
        ->where('karyawans.id_departemen',Auth::user()->id_departemen)
        ->get();

        $departemen = Departemen::All();
        $section = Section::All();

        return view($this->view . 'form', compact('routes','absensi','spv', 'manager','departemen','hr','section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAbsensiRequest $request, Absensi $absensi, $id_absen)
    {
        if ($request->jns_absen == 'Cuti') {
            $tahunIni = date('Y');
            $jumlahCuti = Absensi::where('nip', $request->nip)
                ->where('jns_absen', 'Cuti')
                ->whereYear('tgl_absen', $tahunIni)
                ->count();
            $batasCuti = env('BATAS_CUTI');
            if ($jumlahCuti >= $batasCuti) {
                return redirect()->back()->with('error', 'JUMLAH CUTI ANDA TELAH HABIS');
            }
        }
    
        $absensi = Absensi::find($id_absen);
        $absensi->fill($request->all());
        $absensi->save();
    
        return redirect($this->route)->with('success', 'DATA BERHASIL DI UPDATE');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Absensi $absensi, $id_absen)
    {
        $absensi = Absensi::where('id_absen', $id_absen)->first();
        $absensi->delete();
        return redirect($this->route)->with('success', 'DATA BERHASIL DIHAPUS');
    }

    public function persetujuan_spv($id_absen)
    {
        // dd($id_absen);
        $now = Carbon::now();
        $absensi = Absensi::find($id_absen);
        $absensi->tgl_persetujuan_spv = $now;
        $absensi->status_pengajuan = "Pending";
        $absensi->save();
    
        return redirect()->back()->with('success', 'Permohonan Berhasil Disetujui');
    }

    public function penolakan_spv($id_absen)
    {
        // dd($id_absen);
        $absensi = Absensi::find($id_absen);
        $absensi->tgl_persetujuan_spv = "";
        $absensi->status_pengajuan = 'Ditolak';
        $absensi->save();
    
        return redirect()->back()->with('success', 'Permohonan Berhasil Ditolak');
    }

    public function persetujuan_manager($id_absen)
    {
        // dd($id_absen);
        $now = Carbon::now();
        $absensi = Absensi::find($id_absen);
        $absensi->tgl_persetujuan_manager = $now;
        $absensi->status_pengajuan = 'Pending';
        $absensi->save();
    
        return redirect()->back()->with('success', 'Permohonan Berhasil Disetujui');
    }

    public function penolakan_manager($id_absen)
    {
        // dd($id_absen);
        $absensi = Absensi::find($id_absen);
        $absensi->tgl_persetujuan_manager = "";
        $absensi->status_pengajuan = 'Ditolak';
        $absensi->save();
    
        return redirect()->back()->with('success', 'Permohonan Berhasil Ditolak');
    }

    public function verify_hr($id_absen){
        $absensi = Absensi::find($id_absen);
        $absensi->status_pengajuan = 'Diterima';
        $absensi->save();
    
        return redirect()->back()->with('success', 'Permohonan Berhasil Diverifikasi');
    }

    public function print_surat_absensi($nip){
        // $absensi = Absensi::where('nip', $nip)->get();
        $absensi = DB::table('absensis')
        ->join('departemens', 'absensis.id_departemen', '=', 'departemens.id_departemen')
        ->select('absensis.*', 'departemens.nm_dept')
        ->where('absensis.nip',$nip)
        ->where('absensis.status_pengajuan','Diterima')
        ->get();

        $tahunIni = Carbon::now()->year;
        $absensiCuti = Absensi::where('nip', $nip)
        ->where('jns_absen', 'Cuti')
        ->whereYear('tgl_absen', $tahunIni)
        ->where('absensis.status_pengajuan','Diterima')
        ->get();

        $absensiCutiWanita = Absensi::where('nip', $nip)
        ->whereIn('jns_absen', ['Cuti Haid', 'Cuti Kelahiran/Keguguran'])
        ->whereYear('tgl_absen', $tahunIni)
        ->where('absensis.status_pengajuan','Diterima')
        ->get();
        
        $jumlahCuti = $absensiCuti->count();
        $jumlahCutiWanita = $absensiCutiWanita->count();
        
        $no1 = 1;
        $no2 = 1;
        $no3 = 1;

        return view('absen.surat_absensi',compact('absensi','no1','no2','no3','absensiCuti','jumlahCuti','absensiCutiWanita','jumlahCutiWanita'));
    }

    public function showFormUbahJumlahCuti()
    {
        return view('setting.setting_batas_cuti');
    }

    public function updateJumlahCuti(Request $request)
    {
        $data = [
            'BATAS_CUTI' => $request->input('batas_cuti'),
        ];

        foreach ($data as $key => $value) {
            file_put_contents(app()->environmentFilePath(), str_replace(
                "$key=" . env($key), "$key=$value", file_get_contents(app()->environmentFilePath())
            ));
        }

        \Artisan::call('config:clear');
        \Artisan::call('cache:clear');

        return redirect()->back()->with('success', 'BATAS CUTI BERHASIL DIUPDATE');
    }

    public function export()
    {
        return Excel::download(new AbsensiExport, 'Data Absensi.xlsx');
    }

    public function getKaryawanByNip(Request $request)
    {
        $nip = $request->input('nip');
        // $karyawan = Karyawan::where('nip', $nip)->first();

        $karyawan = DB::table('karyawans')
        ->join('departemens','karyawans.id_departemen','=','departemens.id_departemen')
        ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
        ->join('sections','karyawans.id_section','=','sections.id_section')
        ->select('karyawans.*','departemens.nm_dept','sections.nm_section')
        ->where('karyawans.nip', $nip)
        ->first();

        if ($karyawan) {
            return response()->json([
                'success' => true,
                'data' => $karyawan
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Karyawan tidak ditemukan'
            ]);
        }
    }
}