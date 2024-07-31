<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Section;
use App\Models\Karyawan;
use App\Models\Departemen;
use Illuminate\Http\Request;
use App\Exports\KaryawanExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreKaryawanRequest;
use App\Http\Requests\UpdateKaryawanRequest;

class KaryawanController extends Controller
{
    protected $view = 'karyawan.';
    protected $route = '/karyawan/';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $routes =(object)[
            'index'=> $this->route,
            'add' => $this->route . 'create',
        ];

        $karyawan = DB::table('karyawans')
        ->join('departemens','karyawans.id_departemen','=','departemens.id_departemen')
        ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
        ->select('karyawans.*','departemens.nm_dept','jabatans.nm_jabatan')
        ->get();

        return view($this->view.'data',compact('routes','karyawan'));
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
        $departemen = Departemen::All();
        $jabatan = Jabatan::All();
        $section = Section::All();
        return view($this->view.'form',compact('routes','departemen','jabatan','section'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKaryawanRequest $request)
    {
        $request['password'] = Hash::make($request->password);
        Karyawan::create($request->all());
        
        return redirect($this->route)->with('success', 'DATA BERHASIL DISIMPAN');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan, $id_karyawan)
    {
        $karyawan = DB::table('karyawans')
        ->join('departemens','karyawans.id_departemen','=','departemens.id_departemen')
        ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
        ->join('sections','karyawans.id_section','=','sections.id_section')
        ->select('karyawans.*','departemens.nm_dept','jabatans.nm_jabatan','sections.nm_section')
        ->where('karyawans.id_karyawan', $id_karyawan)
        ->first();  
        return view($this->view . 'show', compact('karyawan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan, $id_karyawan)
    {
        $departemen = Departemen::All();
        $jabatan = Jabatan::All();
        $section = Section::All();
        $karyawan = Karyawan::where('id_karyawan', $id_karyawan)->first();
        $routes = (object)[
            'index' => $this->route,
            'save' => $this->route . $karyawan->id_karyawan,
            'is_update' => true,
        ];

        return view($this->view . 'form', compact('routes','karyawan','departemen','jabatan','section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKaryawanRequest $request, Karyawan $karyawan, $id_karyawan)
    {
        // dd($request->all());
        $karyawan = Karyawan::find($id_karyawan);
        $karyawan->nip = $request->nip;
        $karyawan->username = $request->username;
        $karyawan->password = $request->password ? Hash::make($request->password) : $request->old_password;
        $karyawan->nama = $request->nama;
        $karyawan->id_departemen = $request->id_departemen;
        $karyawan->id_jabatan = $request->id_jabatan;
        $karyawan->id_section = $request->id_section;
        $karyawan->role = $request->role;
        $karyawan->tempat_lahir = $request->tempat_lahir;
        $karyawan->tanggal_lahir = $request->tanggal_lahir;
        $karyawan->jenis_kelamin = $request->jenis_kelamin;
        // dd($request->old_password);
        // Cek apakah ada file foto baru yang diunggah
    
        $karyawan->save();
        
        return redirect($this->route)->with('success','DATA BERHASIL DI UPDATE');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan, $id_karyawan)
    {
        $karyawan = Karyawan::where('id_karyawan', $id_karyawan)->first();
        $karyawan->delete();
        return redirect($this->route)->with('success', 'DATA BERHASIL DIHAPUS');
    }

    public function show_profil(){
        $profil = Karyawan::where("id_karyawan",Auth::user()->id_karyawan)->first();

        return view('profil.profile',compact('profil'));
    }

    public function update_profil(Request $req, $id_karyawan){

        $profil = Karyawan::find($id_karyawan);
        
        $profil->username = $req->username;
        $profil->password = $req->password ? Hash::make($req->password) : $req->old_password;
        $profil->nama = $req->nama;
        $profil->tempat_lahir = $req->tempat_lahir;
        $profil->tanggal_lahir = $req->tanggal_lahir;

        $profil->save();

        return redirect()->back()->with('success', 'DATA BERHASIL DIRUBAH');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function export()
    {
        // $data = new KaryawanExport;
        // dd($data->collection(), $data->headings());
        return Excel::download(new KaryawanExport, 'Data Karyawan.xlsx');
    }

        public function getSectionsByDepartemen(Request $request)
    {
        $departemenId = $request->query('departemen_id');
        
        $sections = Section::where('id_departemen', $departemenId)->get(['id_section', 'nm_section']);
        
        return response()->json([
            'sections' => $sections
        ]);
    }

}