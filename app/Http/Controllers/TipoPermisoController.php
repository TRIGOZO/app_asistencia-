<?php

namespace App\Http\Controllers;

use App\Models\TipoPermiso;
use Illuminate\Http\Request;
use App\Http\Requests\tipopermisos\StoreTipoPermisosRequest;
use App\Http\Requests\tipopermisos\UpdateTipoPermisosRequest;
use Illuminate\Support\Facades\DB;
class TipoPermisoController extends Controller
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
    public function store(StoreTipoPermisosRequest $request)
    {
        $request->validated();
        $cargo = TipoPermiso::create([
            'nombre'    => $request->nombre,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Tipo Permiso Registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $cargo = TipoPermiso::where('id', $request->id)->first();
        return $cargo;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipoPermisosRequest $request)
    {
        $request->validated();

        $cargo = TipoPermiso::where('id',$request->id)->first();

        $cargo->nombre           = $request->nombre;
        $cargo->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Tipo Permiso modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $cargo = TipoPermiso::where('id', $request->id)->first();
        $cargo->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Tipo Permiso eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $cargos = TipoPermiso::get();
        return $cargos;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return TipoPermiso::whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }

}
