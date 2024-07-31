<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Departemen;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;

class SectionController extends Controller
{

    protected $view = 'section.';
    protected $route = '/section/';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $routes = (object)[
            'index' => $this->route,
            'save' => $this->route,
            'is_update' => false,
        ];

        $sections = Section::with('departemen')->get();
        $departemen = Departemen::all();

        return view($this->view . 'data', compact('routes', 'sections', 'departemen'));
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
    public function store(StoreSectionRequest $request)
    {
        Section::create($request->all());
        return redirect($this->route)->with('success','DATA BERHASIL DISIMPAN');
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_section)
    {
        $section = Section::with('departemen')->findOrFail($id_section);
        $departemen = Departemen::all();
        $sections = Section::with('departemen')->get();

        $routes = (object)[
            'index' => $this->route,
            'save' => $this->route . $id_section,
            'is_update' => true,
        ];

        return view($this->view . 'data', compact('routes', 'departemen', 'section', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSectionRequest $request, Section $section, $id_section)
    {
        $section = Section::find($id_section);
        $section->fill($request->all());
        $section->save();
        return redirect($this->route)->with('success','DATA BERHASIL DI UPDATE');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section, $id_section)
    {
        $section = Section::where('id_section', $id_section)->first();
        $section->delete();
        return redirect($this->route)->with('success', 'DATA BERHASIL DIHAPUS');
    }
}
