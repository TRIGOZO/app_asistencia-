<?php

namespace App\Http\Controllers;

use App\Models\TipoGuardia;
use Illuminate\Http\Request;
use App\Http\Requests\tipoguardia\StoreTipoGuardiaRequest;
use App\Http\Requests\tipoguardia\UpdateTipoGuardiaRequest;
use Illuminate\Support\Facades\DB;
class TipoGuardiaController extends Controller
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
    public function store(StoreTipoGuardiaRequest $request)
    {
        $request->validated();
        $nombre = str_replace(' ', '', $request->nombre);
        $abreviatura = strtoupper(substr($nombre, 0, 4)); 

        $tipoguardia = TipoGuardia::create([
            'abreviatura'   => $abreviatura,
            'nombre'    => $request->nombre,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Tipo Guardia Registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $tipoguardia = TipoGuardia::where('id', $request->id)->first();
        return $tipoguardia;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipoGuardiaRequest $request)
    {
        $request->validated();

        $tipoguardia = TipoGuardia::where('id',$request->id)->first();

        $tipoguardia->nombre           = $request->nombre;
        $tipoguardia->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Tipo Guardia modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $tipoguardia = TipoGuardia::where('id', $request->id)->first();
        $tipoguardia->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Tipo Guardia eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $tipoguardias = TipoGuardia::get();
        return $tipoguardias;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return TipoGuardia::whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }

}
