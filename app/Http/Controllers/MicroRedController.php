<?php

namespace App\Http\Controllers;

use App\Models\MicroRed;
use Illuminate\Http\Request;
use App\Http\Requests\cargos\StoreCargoRequest;
use App\Http\Requests\cargos\UpdateCargoRequest;
use Illuminate\Support\Facades\DB;
class MicroRedController extends Controller
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
    public function store(StoreCargoRequest $request)
    {
        $request->validated();
        $microred = MicroRed::create([
            'nombre'    => $request->nombre,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'MicroRed Registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $microred = MicroRed::where('id', $request->id)->first();
        return $microred;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCargoRequest $request)
    {
        $request->validated();

        $microred = MicroRed::where('id',$request->id)->first();

        $microred->nombre           = $request->nombre;
        $microred->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'MicroRed modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $microred = MicroRed::where('id', $request->id)->first();
        $microred->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'MicroRed eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $microredes = MicroRed::with('red:id,nombre')->get();
        return $microredes;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return MicroRed::with('red:id,nombre')->whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }

}
