<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;
use App\Http\Requests\cargos\StoreCargoRequest;
use App\Http\Requests\cargos\UpdateCargoRequest;
use App\Models\EstadoCivil;
use App\Models\Personal;
use Illuminate\Support\Facades\DB;
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
    public function store(StoreCargoRequest $request)
    {
        $request->validated();
        $cargo = Cargo::create([
            'nombre'    => $request->nombre,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cargo Registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $cargo = Cargo::where('id', $request->id)->first();
        return $cargo;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCargoRequest $request)
    {
        $request->validated();

        $cargo = Cargo::where('id',$request->id)->first();

        $cargo->nombre           = $request->nombre;
        $cargo->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cargo modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $cargo = Cargo::where('id', $request->id)->first();
        $cargo->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cargo eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $cargos = Cargo::get();
        return $cargos;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Cargo::whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
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