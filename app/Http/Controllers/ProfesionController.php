<?php

namespace App\Http\Controllers;

use App\Models\Profesion;
use Illuminate\Http\Request;
use App\Http\Requests\profesiones\StoreProfesionesRequest;
use App\Http\Requests\profesiones\UpdateProfesionesRequest;
use Illuminate\Support\Facades\DB;
class ProfesionController extends Controller
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
    public function store(StoreProfesionesRequest $request)
    {
        $request->validated();
        $profesion = Profesion::create([
            'nombre'    => $request->nombre,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Profesion Registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $profesion = Profesion::where('id', $request->id)->first();
        return $profesion;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfesionesRequest $request)
    {
        $request->validated();

        $profesion = Profesion::where('id',$request->id)->first();

        $profesion->nombre           = $request->nombre;
        $profesion->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Profesion modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $profesion = Profesion::where('id', $request->id)->first();
        $profesion->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Profesion eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $profesiones = Profesion::get();
        return $profesiones;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Profesion::whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }

}
