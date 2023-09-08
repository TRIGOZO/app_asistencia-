<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Personal\StorePersonalRequest;
use App\Http\Requests\Personal\UpdatePersonalRequest;
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
    public function store(StorePersonalRequest $request)
    {
        $request->validated();
        $personal = Personal::create([
            'numero_dni'            => $request->numero_dni,
            'nombres'               => $request->nombres,
            'apellido_paterno'      => $request->apellido_paterno,
            'apellido_materno'      => $request->apellido_materno,
            'sexo'                  => $request->sexo,
            'fecha_nacimiento'      => $request->fecha_nacimiento,
            'estado_civil_id'       => $request->estado_civil_id,
            'celular'               => $request->celular,
            'email'                 => $request->email,
            'tipo_trabajador_id'    => $request->tipo_trabajador_id,
            'tienehijos'            => $request->tienehijos,
            'profesion_id'          => $request->profesion_id,
            'cargo_id'              => $request->cargo_id,
            'nivel_id'              => $request->nivel_id,
            'sueldo'                => $request->sueldo,
            'condicion_laboral_id'  => $request->condicion_laboral_id,
            'fecha_inicio'          => $request->fecha_inicio,
            'fecha_fin'             => $request->fecha_fin,
            'establecimiento_id'    => $request->establecimiento_id,
            'direccion'             => $request->direccion,
            'telefono'              => $request->telefono,

        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Personal Registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $personal = Personal::where('id', $request->id)->first();
        return $personal;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonalRequest $request)
    {
        $request->validated();

        $personal = Personal::findOrFail($request->id);

        $personal->update([
            'numero_dni'            => $request->numero_dni,
            'nombres'               => $request->nombres,
            'apellido_paterno'      => $request->apellido_paterno,
            'apellido_materno'      => $request->apellido_materno,
            'sexo'                  => $request->sexo,
            'fecha_nacimiento'      => $request->fecha_nacimiento,
            'estado_civil_id'       => $request->estado_civil_id,
            'celular'               => $request->celular,
            'email'                 => $request->email,
            'tipo_trabajador_id'    => $request->tipo_trabajador_id,
            'tienehijos'            => $request->tienehijos,
            'profesion_id'          => $request->profesion_id,
            'cargo_id'              => $request->cargo_id,
            'nivel_id'              => $request->nivel_id,
            'sueldo'                => $request->sueldo,
            'condicion_laboral_id'  => $request->condicion_laboral_id,
            'fecha_inicio'          => $request->fecha_inicio,
            'fecha_fin'             => $request->fecha_fin,
            'establecimiento_id'    => $request->establecimiento_id,
            'direccion'             => $request->direccion,
            'telefono'              => $request->telefono,
        ]);

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
        $personal = Personal::where('id', $request->id)->first();
        $personal->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Personal eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $personals = Personal::get();
        return $personals;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Personal::with(['estado_civil:id,nombre', 'profesion:id,nombre', 'cargo:id,nombre', 'establecimiento:id,nombre', 'condicion:id,nombre'])
        ->whereRaw('UPPER(nombres) LIKE ?', ['%'.$buscar.'%'])
        ->orWhereRaw('UPPER(apellido_paterno) LIKE ?', ['%'.$buscar.'%'])
        ->orWhereRaw('UPPER(apellido_materno) LIKE ?', ['%'.$buscar.'%'])
        ->orWhereRaw('numero_dni LIKE ?', ['%'.$buscar.'%'])
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
