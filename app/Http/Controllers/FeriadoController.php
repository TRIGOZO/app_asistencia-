<?php

namespace App\Http\Controllers;

use App\Models\Feriado;
use Illuminate\Http\Request;
use App\Http\Requests\feriados\StoreFeriadosRequest;
use App\Http\Requests\feriados\UpdateFeriadosRequest;
class FeriadoController extends Controller
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
    public function store(StoreFeriadosRequest $request)
    {
        $request->validated();
        $cargo = Feriado::create([
            'nombre'    => $request->nombre,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Feriado Registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $cargo = Feriado::where('id', $request->id)->first();
        return $cargo;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeriadosRequest $request)
    {
        $request->validated();

        $cargo = Feriado::where('id',$request->id)->first();

        $cargo->nombre           = $request->nombre;
        $cargo->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Feriado modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $cargo = Feriado::where('id', $request->id)->first();
        $cargo->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Feriado eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $cargos = Feriado::get();
        return $cargos;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Feriado::whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }

}
