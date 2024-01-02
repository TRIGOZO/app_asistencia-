<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Personal\StorePersonalRequest;
use App\Http\Requests\Personal\UpdatePersonalRequest;
use App\Models\EstadoCivil;
use App\Models\Personal;
use App\Models\TipoTrabajador;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
            'observacion'           => $request->observacion,
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

    public function obtetenerDni(Request $request){
        $personal = Personal::where('numero_dni', $request->dni)->first();
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
            'observacion'           => $request->observacion,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Personal modificado satisfactoriamente'
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
        $personals = Personal::where('establecimiento_id', Auth::user()->establecimiento_id)->get();
        return $personals;
    }
    public function listar(Request $request){
        $establecimiento_id = Auth::user()->establecimiento_id;
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        $consulta= Personal::with([
            'estado_civil:id,nombre',
            'profesion:id,nombre',
            'cargo:id,nombre',
            'establecimiento:id,nombre',
            'condicion:id,nombre'
        ])
        ->where(function($query) use ($buscar) {
            $query->whereRaw('UPPER(nombres) LIKE ?', ['%'.$buscar.'%'])
                ->orWhereRaw('UPPER(apellido_paterno) LIKE ?', ['%'.$buscar.'%'])
                ->orWhereRaw('UPPER(apellido_materno) LIKE ?', ['%'.$buscar.'%'])
                ->orWhereRaw('numero_dni LIKE ?', ['%'.$buscar.'%']);
        })->orderBy('apellido_paterno');
        if( Auth::user()->role_id==2){//si es admin
            $consulta->where('establecimiento_id', $establecimiento_id);
        }
        return $consulta->paginate($paginacion);
    }
    public function obtenerPersonalesEstablecimiento(Request $request){

        // $personales = Personal::where('establecimiento_id', $request->establecimiento_id)
        // ->where('tipo_trabajador_id', $asistencial_id)
        // ->when($request->profesion_id != '', function ($query) use ($request) {
        //     return $query->where('profesion_id', $request->profesion_id);
        // })
        // ->where('es_activo', 1)
        // ->orderBy('apellido_paterno', 'asc')
        // ->get();
        // $fecha = Carbon::create($anoActual, $request->mes_numero, 1);
        // setlocale(LC_TIME, 'es_ES.utf8');
        // $diasDelMes = [];
        // while ($fecha->month == $request->mes_numero) {
        //     $nombreDia = $fecha->formatLocalized('%A');
        //     $nombreDia= strtoupper(substr($nombreDia,0,1));
        //     $dia = $fecha->day;
        //     $diasDelMes[] = [
        //         'dia'       => $dia,
        //         'nombreDia' => $nombreDia,
        //     ];
        //     $fecha->addDay();
        // }



        $personales = Personal::getAllPersonalesConTurnos($request);

        return response()->json([
            'personales' => $personales,
        ],200);
    }
    public function mostrarpersonadetalle(Request $request){
        $personal= Personal::join('estados_civiles', 'personales.estado_civil_id', '=', 'estados_civiles.id')
        ->leftjoin('profesiones', 'personales.profesion_id', '=', 'profesiones.id')
        ->leftjoin('cargos', 'personales.cargo_id', '=', 'cargos.id')
        ->leftjoin('establecimientos', 'personales.establecimiento_id', '=', 'establecimientos.id')
        ->select('personales.*', 'establecimientos.nombre as establecimiento', 'estados_civiles.nombre as estado_civil_nombre', 'profesiones.nombre as profesiones_nombre', 'cargos.nombre as cargo_nombre')
        ->where('personales.id', $request->id)
        ->first();
        return $personal;        
    }
    public function estados_civiles(){
        $estadosciviles = EstadoCivil::get();
        return $estadosciviles;
    }
}
