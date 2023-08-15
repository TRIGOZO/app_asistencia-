<?php

namespace App\Http\Controllers;

use App\Models\Red;
use Illuminate\Http\Request;
use App\Http\Requests\redes\StoreRedesRequest;
use App\Http\Requests\redes\UpdateRedesRequest;
use Illuminate\Support\Facades\DB;
class RedController extends Controller
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
    public function store(StoreRedesRequest $request)
    {
        $request->validated();
        $cargo = Red::create([
            'nombre'    => $request->nombre,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Red Registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $cargo = Red::where('id', $request->id)->first();
        return $cargo;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRedesRequest $request)
    {
        $request->validated();

        $cargo = Red::where('id',$request->id)->first();

        $cargo->nombre           = $request->nombre;
        $cargo->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Red modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $cargo = Red::where('id', $request->id)->first();
        $cargo->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Red eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $cargos = Red::get();
        return $cargos;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Red::whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }

}
