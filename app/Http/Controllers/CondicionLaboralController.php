<?php

namespace App\Http\Controllers;

use App\Models\CondicionLaboral;
use Illuminate\Http\Request;
use App\Http\Requests\condicionlaboral\StoreCondicionLaboralRequest;
use App\Http\Requests\cargos\UpdateCargoRequest;
class CondicionLaboralController extends Controller
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
    public function store(StoreCondicionLaboralRequest $request)
    {
        $request->validated();
        $condicionlaboral = CondicionLaboral::create([
            'nombre'    => $request->nombre,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Condicion Laboral Registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $condicionlaboral = CondicionLaboral::where('id', $request->id)->first();
        return $condicionlaboral;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCargoRequest $request)
    {
        $request->validated();

        $condicionlaboral = CondicionLaboral::where('id',$request->id)->first();

        $condicionlaboral->nombre           = $request->nombre;
        $condicionlaboral->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Condicion Laboral modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $condicionlaboral = CondicionLaboral::where('id', $request->id)->first();
        $condicionlaboral->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Condicion Laboral eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $condicionlaborals = CondicionLaboral::get();
        return $condicionlaborals;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return CondicionLaboral::whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }

}
