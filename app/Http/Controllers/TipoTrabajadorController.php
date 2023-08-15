<?php

namespace App\Http\Controllers;

use App\Models\TipoTrabajador;
use Illuminate\Http\Request;
use App\Http\Requests\tipotrabajador\StoreTipoTrabajadorRequest;
use App\Http\Requests\tipotrabajador\UpdateTipoTrabajadorRequest;
use Illuminate\Support\Facades\DB;
class TipoTrabajadorController extends Controller
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
    public function store(StoreTipoTrabajadorRequest $request)
    {
        $request->validated();
        $tipotrabajador = TipoTrabajador::create([
            'nombre'    => $request->nombre,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Tipo de Trabajador Registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $tipotrabajador = TipoTrabajador::where('id', $request->id)->first();
        return $tipotrabajador;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipoTrabajadorRequest $request)
    {
        $request->validated();

        $tipotrabajador = TipoTrabajador::where('id',$request->id)->first();

        $tipotrabajador->nombre           = $request->nombre;
        $tipotrabajador->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Tipo de Trabajador modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $tipotrabajador = TipoTrabajador::where('id', $request->id)->first();
        $tipotrabajador->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Tipo de Trabajador eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $tipotrabajadors = TipoTrabajador::get();
        return $tipotrabajadors;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return TipoTrabajador::whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }

}
