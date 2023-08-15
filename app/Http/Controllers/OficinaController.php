<?php

namespace App\Http\Controllers;

use App\Models\Oficina;
use Illuminate\Http\Request;
use App\Http\Requests\oficinas\StoreOficinaRequest;
use App\Http\Requests\oficinas\UpdateOficinaRequest;
use Illuminate\Support\Facades\DB;
class OficinaController extends Controller
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
    public function store(StoreOficinaRequest $request)
    {
        $request->validated();
        $oficina = Oficina::create([
            'nombre'    => $request->nombre,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Oficina Registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $oficina = Oficina::where('id', $request->id)->first();
        return $oficina;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOficinaRequest $request)
    {
        $request->validated();

        $oficina = Oficina::where('id',$request->id)->first();

        $oficina->nombre           = $request->nombre;
        $oficina->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Oficina modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $oficina = Oficina::where('id', $request->id)->first();
        $oficina->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Oficina eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $oficinas = Oficina::get();
        return $oficinas;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Oficina::whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }

}
