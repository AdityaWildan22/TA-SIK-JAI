<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Section;
use App\Models\Karyawan;
use App\Models\Overtime;
use App\Models\Departemen;
use App\Exports\OvertimeExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreOvertimeRequest;
use App\Http\Requests\UpdateOvertimeRequest;

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
        ->join('karyawans','overtimes.nip','=','karyawans.nip')
        ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
        ->select('overtimes.*','karyawans.*','departemens.nm_dept','jabatans.nm_jabatan');
    
        // Jika pengguna adalah "Staff", hanya tampilkan data absensi yang terkait dengan 'nip' mereka
        if ($user->role === 'Staff') {
            $overtime->where('overtimes.nip', $user->nip);
        }else if($user->role === 'SPV' || $user->role === 'Manager'){
            $overtime->where('overtimes.id_departemen',$user->id_departemen);
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


        return view($this->view.'form',compact('routes','manager','spv','departemen','hr','section'));
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
        ->join('karyawans', 'overtimes.nip', '=', 'karyawans.nip')
        ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
        ->select('overtimes.*', 'departemens.nm_dept','jabatans.nm_jabatan')
        ->where('overtimes.id_ovt',$id_ovt)
        ->first();

        $manager = DB::table("overtimes")
        ->join("karyawans","overtimes.id_manager","=","karyawans.nip")
        ->select("karyawans.nama")
        ->where("karyawans.nip",$overtime->id_manager)
        ->first();

        $spv = DB::table("overtimes")
        ->join("karyawans","overtimes.id_spv","=","karyawans.nip")
        ->select("karyawans.nama")
        ->where("karyawans.nip",$overtime->id_spv)
        ->first();

        $hr = DB::table("overtimes")
        ->join("karyawans","overtimes.id_hr","=","karyawans.nip")
        ->select("karyawans.nama")
        ->where("karyawans.nip",$overtime->id_hr)
        ->first();

        // dd($atasan);
        return view($this->view . 'show', compact('overtime','manager','spv','hr'));
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

        return view($this->view . 'form', compact('routes','overtime','spv', 'manager','departemen','hr','section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOvertimeRequest $request, Overtime $overtime, $id_ovt)
    {
        // dd($request->all());
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

    public function persetujuan_spv($id_ovt)
    {
        // dd($id_ovt);
        $now = Carbon::now();
        $overtime = Overtime::find($id_ovt); 
        $overtime->tgl_persetujuan_spv = $now;
        $overtime->status_pengajuan = 'Pending';
        $overtime->save();
    
        return redirect()->back()->with('success', 'Permohonan Berhasil Disetujui');
    }

    public function penolakan_spv($id_ovt)
    {
        // dd($id_ovt);
        $overtime = Overtime::find($id_ovt); 
        $overtime->tgl_persetujuan_spv = "";
        $overtime->status_pengajuan = 'Ditolak';
        $overtime->save();
    
        return redirect()->back()->with('success', 'Permohonan Berhasil Ditolak');
    }

    public function verify_hr($id_ovt){
        $overtime = Overtime::find($id_ovt);
        $overtime->status_pengajuan = 'Diterima';
        $overtime->id_hr = Auth::user()->nip;
        $overtime->save();
    
        return redirect()->back()->with('success', 'Permohonan Berhasil Diverifikasi');
    }

    // public function persetujuan_atasan($id_ovt)
    // {
    //     // dd($id_ovt);
    //     $now = Carbon::now();
    //     $overtime = Overtime::find($id_ovt);
    //     $overtime->tgl_persetujuan_manager = $now;
    //     $overtime->status_pengajuan = 'Diterima';
    //     $overtime->save();
    
    //     return redirect()->back()->with('success', 'Permohonan Berhasil Disetujui');
    // }

    // public function penolakan_atasan($id_ovt)
    // {
    //     // dd($id_ovt);
    //     $overtime = Overtime::find($id_ovt);
    //     $overtime->tgl_persetujuan_manager = "";
    //     $overtime->status_pengajuan = 'Ditolak';
    //     $overtime->save();
    
    //     return redirect()->back()->with('success', 'Permohonan Berhasil Ditolak');
    // }

    public function print_surat_overtime($id_ovt){
        $overtime = Overtime::find($id_ovt)
        ->join('departemens', 'overtimes.id_departemen', '=', 'departemens.id_departemen')
        ->select('overtimes.*', 'departemens.nm_dept')
        ->first();
        // dd($overtime->nip);
        $karyawan = DB::table("overtimes")
        ->join("karyawans","overtimes.nip","=","karyawans.nip")
        ->join("jabatans","karyawans.id_jabatan","=","jabatans.id_jabatan")
        ->select("karyawans.*","jabatans.nm_jabatan")
        ->where("karyawans.nip",$overtime->nip)
        ->first();
       
        // $manager = DB::table("overtimes")
        // ->join("karyawans","overtimes.id_manager","=","karyawans.nip")
        // ->join("jabatans","karyawans.id_jabatan","=","jabatans.id_jabatan")
        // ->select("karyawans.*","jabatans.nm_jabatan")
        // ->where("karyawans.nip",$overtime->id_manager)
        // ->first();

        $spv = DB::table("overtimes")
        ->join("karyawans","overtimes.id_spv","=","karyawans.nip")
        ->join("jabatans","karyawans.id_jabatan","=","jabatans.id_jabatan")
        ->select("karyawans.*","jabatans.nm_jabatan")
        ->where("karyawans.nip",$overtime->id_spv)
        ->first();

        $hr = DB::table("overtimes")
        ->join("karyawans","overtimes.id_hr","=","karyawans.nip")
        ->join("jabatans","karyawans.id_jabatan","=","jabatans.id_jabatan")
        ->select("karyawans.*","jabatans.nm_jabatan")
        ->where("karyawans.nip",$overtime->id_hr)
        ->first();

        return view('overtime.surat_overtime',compact('overtime','spv','karyawan','hr'));
    }

    public function export()
    {
        return Excel::download(new OvertimeExport, 'Data Overtime.xlsx');
    }

    public function getKaryawanNip(Request $request)
    {
        $nip = $request->input('nip');
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