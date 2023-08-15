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
        $feriado = Feriado::create([
            'nombre'    => $request->nombre,
            'fecha'     => $request->fecha,
            'establecimiento_id'    => $request->establecimiento_id
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
        $feriado = Feriado::where('id', $request->id)->first();
        return $feriado;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeriadosRequest $request)
    {
        $request->validated();

        $feriado = Feriado::where('id',$request->id)->first();

        $feriado->nombre           = $request->nombre;
        $feriado->fecha                    = $request->fecha;
        $feriado->establecimiento_id       = $request->establecimiento_id;
        $feriado->save();

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
        $feriado = Feriado::where('id', $request->id)->first();
        $feriado->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Feriado eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $feriados = Feriado::with('establecimiento:id,nombre')->get();
        return $feriados;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Feriado::with('establecimiento:id,nombre')->whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }

}
