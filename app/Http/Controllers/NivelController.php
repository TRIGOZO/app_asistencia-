<?php

namespace App\Http\Controllers;

use App\Models\Nivel;
use Illuminate\Http\Request;
use App\Http\Requests\niveles\StoreNivelRequest;
use App\Http\Requests\niveles\UpdateNivelRequest;
use Illuminate\Support\Facades\DB;
class NivelController extends Controller
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
    public function store(StoreNivelRequest $request)
    {
        $request->validated();
        $nivel = Nivel::create([
            'nombre'    => $request->nombre,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Nivel Registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $nivel = Nivel::where('id', $request->id)->first();
        return $nivel;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNivelRequest $request)
    {
        $request->validated();

        $nivel = Nivel::where('id',$request->id)->first();

        $nivel->nombre           = $request->nombre;
        $nivel->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Nivel modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $nivel = Nivel::where('id', $request->id)->first();
        $nivel->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Nivel eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $nivels = Nivel::get();
        return $nivels;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Nivel::whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }

}
