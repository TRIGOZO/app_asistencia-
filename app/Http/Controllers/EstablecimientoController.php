<?php

namespace App\Http\Controllers;

use App\Models\Establecimiento;
use Illuminate\Http\Request;
use App\Http\Requests\establecimientos\StoreEstablecimientoRequest;
use App\Http\Requests\establecimientos\UpdateEstablecimientoRequest;
class EstablecimientoController extends Controller
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
    public function store(StoreEstablecimientoRequest $request)
    {
        $request->validated();
        $establecimiento = Establecimiento::create([
            'nombre'    => $request->nombre,
            'microred_id' => $request->microred_id
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Establecimiento Registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $establecimiento = Establecimiento::where('id', $request->id)->first();
        return $establecimiento;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEstablecimientoRequest $request)
    {
        $request->validated();

        $establecimiento = Establecimiento::where('id',$request->id)->first();

        $establecimiento->nombre           = $request->nombre;
        $establecimiento->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Establecimiento modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $establecimiento = Establecimiento::where('id', $request->id)->first();
        $establecimiento->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Establecimiento eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $establecimientos = Establecimiento::with('microred:id,nombre')->get();
        return $establecimientos;
    }
    public function todos_general(){
        $establecimientos = Establecimiento::get();
        return $establecimientos;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Establecimiento::with('microred:id,nombre')->whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }

}
