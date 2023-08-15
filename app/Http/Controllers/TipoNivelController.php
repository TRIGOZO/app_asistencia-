<?php

namespace App\Http\Controllers;

use App\Models\TipoNivel;
use Illuminate\Http\Request;
use App\Http\Requests\tiponiveles\StoreTipoNivelesRequest;
use App\Http\Requests\tiponiveles\UpdateTipoNivelesRequest;
class TipoNivelController extends Controller
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
    public function store(StoreTipoNivelesRequest $request)
    {
        $request->validated();
        $tiponivel = TipoNivel::create([
            'nombre'    => $request->nombre,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Tipo Nivel Registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $tiponivel = TipoNivel::where('id', $request->id)->first();
        return $tiponivel;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipoNivelesRequest $request)
    {
        $request->validated();

        $tiponivel = TipoNivel::where('id',$request->id)->first();

        $tiponivel->nombre           = $request->nombre;
        $tiponivel->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Tipo Nivel modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $tiponivel = TipoNivel::where('id', $request->id)->first();
        $tiponivel->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Tipo Nivel eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $tiponivels = TipoNivel::get();
        return $tiponivels;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return TipoNivel::whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }

}
