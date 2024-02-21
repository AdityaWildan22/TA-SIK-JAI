<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Http\Requests\StoreKaryawanRequest;
use App\Http\Requests\UpdateKaryawanRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

        $karyawan = Karyawan::All();

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

        return view($this->view.'form',compact('routes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKaryawanRequest $request)
    {
    // dd($request->foto);
        $foto = $request->foto;
        $karyawan = new Karyawan;
        $karyawan->nip = $request->nip;
        $karyawan->username = $request->username;
        $karyawan->password = Hash::make($request->password);
        $karyawan->nama = $request->nama;
        $karyawan->sect = $request->sect;
        $karyawan->divisi = $request->divisi;
        $karyawan->tempat_lahir = $request->tempat_lahir;
        $karyawan->tanggal_lahir = $request->tanggal_lahir;
        $karyawan->foto_ttd = $foto;
        $karyawan->save();
        
        return redirect($this->route)->with('success', 'DATA BERHASIL DISIMPAN');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan, $id_karyawan)
    {
        $karyawan = Karyawan::find($id_karyawan);
        return view($this->view . 'show', compact('karyawan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan, $id_karyawan)
    {
        $karyawan = Karyawan::where('id_karyawan', $id_karyawan)->first();
        $routes = (object)[
            'index' => $this->route,
            'save' => $this->route . $karyawan->id_karyawan,
            'is_update' => true,
        ];

        return view($this->view . 'form', compact('routes','karyawan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKaryawanRequest $request, Karyawan $karyawan, $id_karyawan)
    {
        $fotoBase64 = $request->foto;

        $karyawan = Karyawan::find($id_karyawan);
        $karyawan->nip = $request->nip;
        $karyawan->username = $request->username;
        $karyawan->password = $request->password ? Hash::make($request->password) : $request->old_password;
        $karyawan->nama = $request->nama;
        $karyawan->sect = $request->sect;
        $karyawan->divisi = $request->divisi;
        $karyawan->tempat_lahir = $request->tempat_lahir;
        $karyawan->tanggal_lahir = $request->tanggal_lahir;
        // dd($request->old_password);
        // Cek apakah ada file foto baru yang diunggah
        if ($request->hasFile('foto_ttd')) {
            // Ambil data gambar base64 dari request
            $fotoBase64 = $request->foto ;
            $karyawan->foto_ttd = $fotoBase64; // Simpan foto dalam bentuk base64
        }
    
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

        $fotoBase64 = $req->foto;
        $profil = Karyawan::find($id_karyawan);
        
        $profil->username = $req->username;
        $profil->password = $req->password ? Hash::make($req->password) : $req->old_password;
        $profil->nama = $req->nama;
        $profil->sect = $req->sect;
        $profil->tempat_lahir = $req->tempat_lahir;
        $profil->tanggal_lahir = $req->tanggal_lahir;
    
        // Cek apakah ada file foto baru yang diunggah
        if ($req->hasFile('foto_ttd')) {
            // Ambil data gambar base64 dari request
            $fotoBase64 = $req->foto ;
            $profil->foto_ttd = $fotoBase64; // Simpan foto dalam bentuk base64
            // dd($profil->foto_ttd);
        }

        $profil->save();

        return redirect()->back()->with('success', 'DATA BERHASIL DIRUBAH');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}