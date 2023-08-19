<?php

namespace App\Http\Controllers;
use App\Http\Requests\permiso\StorePermisoRequest;
use App\Http\Requests\permiso\UpdatePermisoRequest;
use App\Models\Permiso;
use Illuminate\Http\Request;

class PermisoController extends Controller
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
    public function store(StorePermisoRequest $request)
    {
        $request->validated();
        $permiso = Permiso::create([
            'nombre'    => $request->nombre,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cargo Registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $permiso = Permiso::where('id', $request->id)->first();
        return $permiso;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermisoRequest $request)
    {
        $request->validated();

        $permiso = Permiso::where('id',$request->id)->first();

        $permiso->nombre           = $request->nombre;
        $permiso->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cargo modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $permiso = Permiso::where('id', $request->id)->first();
        $permiso->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cargo eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $permisos = Permiso::get();
        return $permisos;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Permiso::whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }

}
