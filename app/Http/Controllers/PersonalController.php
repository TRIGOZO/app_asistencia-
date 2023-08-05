<?php

namespace App\Http\Controllers;

use App\Models\EstadoCivil;
use App\Models\Personal;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $personal= Personal::where('id', $request->id)->first();
        return $personal;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function mostrarpersonadetalle(Request $request){
        $personal= Personal::join('estados_civiles', 'personales.estado_civil_id', '=', 'estados_civiles.id')
        ->leftjoin('profesiones', 'personales.profesion_id', '=', 'profesiones.id')
        ->leftjoin('cargos', 'personales.cargo_id', '=', 'cargos.id')
        ->select('personales.*', 'estados_civiles.nombre as estado_civil_nombre', 'profesiones.nombre as profesiones_nombre', 'cargos.nombre as cargo_nombre')
        ->where('personales.id', $request->id)
        ->first();
        return $personal;        
    }
    public function estados_civiles(){
        $estadosciviles = EstadoCivil::get();
        return $estadosciviles;
    }
}
