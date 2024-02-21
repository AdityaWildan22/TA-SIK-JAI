<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use App\Controller\KaryawanController;
use App\Http\Requests\StoreAbsensiRequest;
use App\Http\Requests\UpdateAbsensiRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;

class AbsensiController extends Controller
{
    protected $view = 'absensi.';
    protected $route = '/absensi/';
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $absensi = Absensi::query();
        
            // Jika pengguna adalah "Staff", hanya tampilkan data absensi yang terkait dengan 'nip' mereka
            if ($user->divisi === 'Staff') {
                $absensi->where('nip', $user->nip);
            }
        
            $absensi = $absensi->get();
        
            $routes = (object) [
                'index' => $this->route,
                'add' => $this->route . 'create',
            ];
        
            return view($this->view . 'data', compact('routes', 'absensi'));
        } else {
            // Jika pengguna tidak terotentikasi, redirect mereka ke halaman login
            // return redirect()->route('login')->with('error', 'Silakan login untuk mengakses halaman ini.');
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

        $staff_hr = Karyawan::where('divisi','Staff HR')->get();
        $atasan = Karyawan::where('divisi','Atasan')->get();

        return view($this->view.'form',compact('routes','staff_hr','atasan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAbsensiRequest $request)
    {
        // dd($request->all());
        $request["status_pengajuan"] = "Diproses";
        Absensi::create($request->all());
        return redirect($this->route)->with('success','DATA BERHASIL DISIMPAN');
    }

    /**
     * Display the specified resource.
     */
    public function show(Absensi $absensi, $id_absen)
    {
        $absensi = Absensi::find($id_absen);

        $atasan = DB::table("absensis")
        ->join("karyawans","absensis.id_atasan","=","karyawans.nip")
        ->select("karyawans.nama")
        ->where("karyawans.nip",$absensi->id_atasan)
        ->first();

        $staff_hr = DB::table("absensis")
        ->join("karyawans","absensis.id_staff_hr","=","karyawans.nip")
        ->select("karyawans.nama")
        ->where("karyawans.nip",$absensi->id_staff_hr)
        ->first();

        // dd($atasan);
        return view($this->view . 'show', compact('absensi','atasan','staff_hr'));
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

        $staff_hr = Karyawan::where('divisi','Staff HR')->get();
        $atasan = Karyawan::where('divisi','Atasan')->get();

        return view($this->view . 'form', compact('routes','absensi','staff_hr', 'atasan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAbsensiRequest $request, Absensi $absensi, $id_absen)
    {
        // dd($request->all());
        // $request["status_pengajuan"] = "Diproses";
        $absensi = Absensi::find($id_absen);
        $absensi->fill($request->all());
        $absensi->save();
        return redirect($this->route)->with('success','DATA BERHASIL DI UPDATE');
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

    public function persetujuan_hr($id_absen)
    {
        // dd($id_absen);
        $now = Carbon::now();
        $absensi = Absensi::find($id_absen);
        $absensi->tgl_persetujuan_staff_hr = $now;
        $absensi->status_pengajuan = 'Pending';
        $absensi->save();
    
        return redirect()->back()->with('success', 'Permohonan Berhasil Disetujui');
    }

    public function penolakan_hr($id_absen)
    {
        // dd($id_absen);
        $absensi = Absensi::find($id_absen);
        $absensi->tgl_persetujuan_staff_hr = "";
        $absensi->status_pengajuan = 'Ditolak';
        $absensi->save();
    
        return redirect()->back()->with('success', 'Permohonan Berhasil Ditolak');
    }

    public function persetujuan_atasan($id_absen)
    {
        // dd($id_absen);
        $now = Carbon::now();
        $absensi = Absensi::find($id_absen);
        $absensi->tgl_persetujuan_atasan = $now;
        $absensi->status_pengajuan = 'Diterima';
        $absensi->save();
    
        return redirect()->back()->with('success', 'Permohonan Berhasil Disetujui');
    }

    public function penolakan_atasan($id_absen)
    {
        // dd($id_absen);
        $absensi = Absensi::find($id_absen);
        $absensi->tgl_persetujuan_atasan = "";
        $absensi->status_pengajuan = 'Ditolak';
        $absensi->save();
    
        return redirect()->back()->with('success', 'Permohonan Berhasil Ditolak');
    }

    public function print_surat_absensi($id_absen){
        $absensi = Absensi::find($id_absen);

        $karyawan = DB::table("absensis")
        ->join("karyawans","absensis.nip","=","karyawans.nip")
        ->select("karyawans.*")
        ->where("karyawans.nip",$absensi->nip)
        ->first();

        // dd($absensi->nip);
        
        $atasan = DB::table("absensis")
        ->join("karyawans","absensis.id_atasan","=","karyawans.nip")
        ->select("karyawans.*")
        ->where("karyawans.nip",$absensi->id_atasan)
        ->first();

        $staff_hr = DB::table("absensis")
        ->join("karyawans","absensis.id_staff_hr","=","karyawans.nip")
        ->select("karyawans.*")
        ->where("karyawans.nip",$absensi->id_staff_hr)
        ->first();

        // Ambil tampilan Blade ke dalam variabel
        $html = view('absensi.surat_absensi',compact('absensi','karyawan','atasan','staff_hr'))->render();
    
        // Konfigurasi dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultPaperSize', 'A4'); // Set ukuran kertas menjadi A4
        $options->set('defaultFont', 'Arial'); // Set font default jika diperlukan
    
        // Buat instance dompdf
        $dompdf = new Dompdf($options);
    
        // Muat HTML ke dalam dompdf
        $dompdf->loadHtml($html);
    
        // Render PDF
        $dompdf->render();
    
        // Tampilkan PDF di browser
        return $dompdf->stream('surat_absensi.pdf', ['Attachment' => false]);
    }
}