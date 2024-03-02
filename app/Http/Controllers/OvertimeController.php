<?php

namespace App\Http\Controllers;

use App\Models\Overtime;
use App\Models\Karyawan;
use App\Models\Departemen;
use App\Http\Requests\StoreOvertimeRequest;
use App\Http\Requests\UpdateOvertimeRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;

class OvertimeController extends Controller
{
    protected $view = 'overtime.';
    protected $route = '/overtime/';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {if (auth()->check()) {
        $user = auth()->user();
        $overtime = DB::table('overtimes')
        ->join('departemens','overtimes.id_departemen','=','departemens.id_departemen')
        ->select('overtimes.*','departemens.nm_dept');
    
        // Jika pengguna adalah "Staff", hanya tampilkan data absensi yang terkait dengan 'nip' mereka
        if ($user->role === 'Staff') {
            $overtime->where('nip', $user->nip);
        }
    
        $overtime = $overtime->get();
    
        $routes = (object) [
            'index' => $this->route,
            'add' => $this->route . 'create',
        ];
    
        return view($this->view . 'data', compact('routes', 'overtime'));
    } else {
        // Jika pengguna tidak terotentikasi, redirect mereka ke halaman login
        // return redirect()->route('login')->with('error', 'Silakan login untuk mengakses halaman ini.');
        $overtime = DB::table('overtimes')
        ->join('departemens','overtimes.id_departemen','=','departemens.id_departemen')
        ->select('overtimes.*','departemens.nm_dept')
        ->get();
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

        $manager = Karyawan::where('role','Manager')->get();
        $spv = Karyawan::where('role','SPV')->get();
        $departemen = Departemen::All();


        return view($this->view.'form',compact('routes','manager','spv','departemen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOvertimeRequest $request)
    {
        // dd($request->all());
        $request["status_pengajuan"] = "Diproses";
        Overtime::create($request->all());
        return redirect($this->route)->with('success','DATA BERHASIL DISIMPAN');
    }

    /**
     * Display the specified resource.
     */
    public function show(Overtime $overtime, $id_ovt)
    {
        $overtime = Overtime::find($id_ovt)
        ->join('departemens', 'overtimes.id_departemen', '=', 'departemens.id_departemen')
        ->select('overtimes.*', 'departemens.nm_dept')
        ->first();

        $manager = DB::table("overtimes")
        ->join("karyawans","overtimes.id_atasan","=","karyawans.nip")
        ->select("karyawans.nama")
        ->where("karyawans.nip",$overtime->id_atasan)
        ->first();

        $spv = DB::table("overtimes")
        ->join("karyawans","overtimes.id_staff_hr","=","karyawans.nip")
        ->select("karyawans.nama")
        ->where("karyawans.nip",$overtime->id_staff_hr)
        ->first();

        // dd($atasan);
        return view($this->view . 'show', compact('overtime','manager','spv'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Overtime $overtime, $id_ovt)
    {
        $overtime = Overtime::where('id_ovt', $id_ovt)->first();
        $routes = (object)[
            'index' => $this->route,
            'save' => $this->route . $overtime->id_ovt,
            'is_update' => true,
        ];

        $manager = Karyawan::where('role','Manager')->get();
        $spv = Karyawan::where('role','SPV')->get();
        $departemen = Departemen::All();

        return view($this->view . 'form', compact('routes','overtime','spv', 'manager','departemen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOvertimeRequest $request, Overtime $overtime, $id_ovt)
    {
        $overtime = Overtime::find($id_ovt);
        $overtime->fill($request->all());
        $overtime->save();
        return redirect($this->route)->with('success','DATA BERHASIL DI UPDATE');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Overtime $overtime, $id_ovt)
    {
        $overtime = Overtime::where('id_ovt', $id_ovt)->first();
        $overtime->delete();
        return redirect($this->route)->with('success', 'DATA BERHASIL DIHAPUS');
    }

    public function persetujuan_hr($id_ovt)
    {
        // dd($id_ovt);
        $now = Carbon::now();
        $overtime = Overtime::find($id_ovt); 
        $overtime->tgl_persetujuan_staff_hr = $now;
        $overtime->status_pengajuan = 'Pending';
        $overtime->save();
    
        return redirect()->back()->with('success', 'Permohonan Berhasil Disetujui');
    }

    public function penolakan_hr($id_ovt)
    {
        // dd($id_ovt);
        $overtime = Overtime::find($id_ovt); 
        $overtime->tgl_persetujuan_staff_hr = "";
        $overtime->status_pengajuan = 'Ditolak';
        $overtime->save();
    
        return redirect()->back()->with('success', 'Permohonan Berhasil Ditolak');
    }

    public function persetujuan_atasan($id_ovt)
    {
        // dd($id_ovt);
        $now = Carbon::now();
        $overtime = Overtime::find($id_ovt);
        $overtime->tgl_persetujuan_atasan = $now;
        $overtime->status_pengajuan = 'Diterima';
        $overtime->save();
    
        return redirect()->back()->with('success', 'Permohonan Berhasil Disetujui');
    }

    public function penolakan_atasan($id_ovt)
    {
        // dd($id_ovt);
        $overtime = Overtime::find($id_ovt);
        $overtime->tgl_persetujuan_atasan = "";
        $overtime->status_pengajuan = 'Ditolak';
        $overtime->save();
    
        return redirect()->back()->with('success', 'Permohonan Berhasil Ditolak');
    }

    public function print_surat_overtime($id_ovt){
        $overtime = Overtime::find($id_ovt);
        // dd($overtime->nip);
        $karyawan = DB::table("overtimes")
        ->join("karyawans","overtimes.nip","=","karyawans.nip")
        ->select("karyawans.*")
        ->where("karyawans.nip",$overtime->nip)
        ->first();
       
        $atasan = DB::table("overtimes")
        ->join("karyawans","overtimes.id_atasan","=","karyawans.nip")
        ->select("karyawans.*")
        ->where("karyawans.nip",$overtime->id_atasan)
        ->first();

        $staff_hr = DB::table("overtimes")
        ->join("karyawans","overtimes.id_staff_hr","=","karyawans.nip")
        ->select("karyawans.*")
        ->where("karyawans.nip",$overtime->id_staff_hr)
        ->first();

        // Ambil tampilan Blade ke dalam variabel
        $html = view('overtime.surat_overtime',compact('overtime','atasan','staff_hr','karyawan'))->render();
    
        // Konfigurasi dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultPaperSize', 'F4'); // Set ukuran kertas menjadi A4
        $options->set('defaultFont', 'Arial'); // Set font default jika diperlukan
        $options->set('defaultPaperOrientation', 'landscape');
    
        // Buat instance dompdf
        $dompdf = new Dompdf($options);
    
        // Muat HTML ke dalam dompdf
        $dompdf->loadHtml($html);
    
        // Render PDF
        $dompdf->render();
    
        // Tampilkan PDF di browser
        return $dompdf->stream('surat_overtime.pdf', ['Attachment' => false]);

        // return view('overtime.surat_overtime',compact('overtime','atasan','staff_hr','karyawan'));
    }
}