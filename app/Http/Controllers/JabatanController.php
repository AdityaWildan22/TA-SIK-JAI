<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Departemen;
use App\Http\Requests\StoreJabatanRequest;
use App\Http\Requests\UpdateJabatanRequest;
use Illuminate\Support\Facades\DB;

class JabatanController extends Controller
{
    protected $view = 'jabatan.';
    protected $route = '/jabatan/';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $routes =(object)[
            'index'=> $this->route,
            'save' => $this->route,
            'is_update'=>false,
        ];

        $jabatan = DB::table('jabatans')
        ->join('departemens','jabatans.id_dept','=','departemens.id_departemen')
        ->select('departemens.nm_dept','jabatans.*')
        ->get();
        $departemen = Departemen::All();
        // dd($jabatan->all());
        return view($this->view.'data',compact('routes','jabatan','departemen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJabatanRequest $request)
    {
        Jabatan::create($request->all());
        return redirect($this->route)->with('success','DATA BERHASIL DISIMPAN');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jabatan $jabatan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jabatan $jabatan, $id_jabatan)
    {
        $jab = Jabatan::where('id_jabatan', $id_jabatan)->first(); 
        $jabatan = DB::table('jabatans')
        ->join('departemens','jabatans.id_dept','=','departemens.id_departemen')
        ->select('departemens.nm_dept','jabatans.*')
        ->get();
        $departemen = Departemen::All();
        $routes = (object)[
            'index' => $this->route,
            'save' => $this->route . $jab->id_jabatan,
            'is_update' => true,
        ];
        return view($this->view . 'data', compact('routes', 'departemen', 'jab','jabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJabatanRequest $request, Jabatan $jabatan, $id_jabatan)
    {
        $jabatan = Jabatan::find($id_jabatan);
        $jabatan->fill($request->all());
        $jabatan->save();
        return redirect($this->route)->with('success','DATA BERHASIL DI UPDATE');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jabatan $jabatan, $id_jabatan)
    {
        $jabatan = Jabatan::where('id_jabatan', $id_jabatan)->first();
        $jabatan->delete();
        return redirect($this->route)->with('success', 'DATA BERHASIL DIHAPUS');
    }
}