<?php

namespace App\Http\Controllers;

use App\Models\TipoTurno;
use Illuminate\Http\Request;
use App\Http\Requests\tipoturno\StoreTipoTurnoRequest;
use App\Http\Requests\tipoturno\UpdateTipoTurnoRequest;
use Illuminate\Support\Facades\DB;
class TipoTurnoController extends Controller
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
    public function store(StoreTipoTurnoRequest $request)
    {
        $request->validated();
        $tipoturno = TipoTurno::create([
            'abreviatura' => $request->abreviatura,
            'nombre'    => $request->nombre,
            'diastolerancia' => $request->diastolerancia,
            'descuento' => $request->descuento,
            'guardia' => $request->guardia,
            'permiso' => $request->permiso,
            'horasantesdescansa' => $request->horasantesdescansa,
            'horasdespuesdescansa' => $request->horasdespuesdescansa,
            'horaasistencial' => $request->horaasistencial,
            'horaadministrativo' => $request->horaadministrativo,
            'nroturnos' => $request->nroturnos
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Tipo de Turno Registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $tipoturno = TipoTurno::withCount('horario')->where('id', $request->id)->first();
        return $tipoturno;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipoTurnoRequest $request)
    {
        $request->validated();
        $tipoturno = TipoTurno::where('id',$request->id)->first();
        $nombre = str_replace(' ', '', $request->nombre);
        $abreviatura = strtoupper(substr($nombre, 0, 4));
        if($nombre=='MAÑANA'){
            $abreviatura='M';
        }
        if($nombre=='TARDE'){
            $abreviatura='T';
        }
        $tipoturno->update([
            'abreviatura' => $abreviatura,
            'nombre'    => $request->nombre,
            'diastolerancia' => $request->diastolerancia,
            'descuento' => $request->descuento,
            'guardia' => $request->guardia,
            'permiso' => $request->permiso,
            'horasantesdescansa' => $request->horasantesdescansa,
            'horasdespuesdescansa' => $request->horasdespuesdescansa,
            'horaasistencial' => $request->horaasistencial,
            'horaadministrativo' => $request->horaadministrativo,
            'nroturnos' => $request->nroturnos
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Tipo Turno modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $tipoturno = TipoTurno::where('id', $request->id)->first();
        $tipoturno->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Tipo Turno eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $tipoturnos = TipoTurno::get();
        return $tipoturnos;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return TipoTurno::withCount('horario')->whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }

}
