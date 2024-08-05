<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Http\Requests\StoreDepartemenRequest;
use App\Http\Requests\UpdateDepartemenRequest;

class DepartemenController extends Controller
{
    protected $view = 'departemen.';
    protected $route = '/departemen/';
     
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
        $departemen = Departemen::All();
        // dd($departemen->all());
        return view($this->view.'data',compact('routes','departemen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartemenRequest $request)
    {
        Departemen::create($request->all());
        $mess = ["type" => "success", "text" => "Data Departemen Berhasil Disimpan"];
        return redirect($this->route)->with($mess);
    }

    /**
     * Display the specified resource.
     */
    public function show(Departemen $departemen)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departemen $departemen, $id_departemen)
    {
        {
            $dept = Departemen::where('id_departemen', $id_departemen)->first(); // 
            $departemen = Departemen::all();
            $routes = (object)[
                'index' => $this->route,
                'save' => $this->route . $dept->id_departemen,
                'is_update' => true,
            ];
        
            return view($this->view . 'data', compact('routes', 'departemen', 'dept'));
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartemenRequest $request, Departemen $departemen, $id_departemen)
    {
        $departemen = Departemen::find($id_departemen);
        $departemen->fill($request->all());
        $departemen->save();
        $mess = ["type" => "success", "text" => "Data Departemen Berhasil Dirubah"];
        return redirect($this->route)->with($mess);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departemen $departemen, $id_departemen)
    {
        $departemen = Departemen::where('id_departemen', $id_departemen)->first();
        $departemen->delete();
        $mess = ["type" => "success", "text" => "Data Departemen Berhasil Dihapus"];
        return redirect($this->route)->with($mess);
    }
}