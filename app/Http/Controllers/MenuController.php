<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use Illuminate\Http\Request;

use App\Models\Cargo;
use App\Http\Requests\menus\StoreMenuRequest;
use App\Http\Requests\menus\UpdateMenuRequest;

class MenuController extends Controller
{
    public function mostrarmenuslug(Request $request){
        return Menu::where('slug',$request->slug)->first();
    }
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuRequest $request)
    {
        $request->validated();

        //$orden=0;
        if($request->padre_id !='' || $request->padre_id != null)
        {
            $orden = Menu::maximoHijoId($request->padre_id);
        } else {
            $orden = Menu::maximoPadreId();
        }
        
        $menu = Menu::create([
            'nombre'    => $request->nombre,
            'slug'      => $request->slug,
            'icono'     => $request->icono,
            'padre_id'  => $request->padre_id ,
            'orden'     => $orden
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Menu Registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $menu = Menu::where('id', $request->id)->first();
        return $menu;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuRequest $request)
    {
        $request->validated();

        $menu = Menu::where('id',$request->id)->first();

        $menu->nombre           = $request->nombre;
        $menu->slug             = $request->slug;
        $menu->icono            = $request->icono;
        $menu->padre_id         = $request->padre_id;
        $menu->orden            = $request->orden;
        $menu->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Menu modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $menu = Menu::where('id', $request->id)->first();
        $menu->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cargo eliminado satisfactoriamente'
        ],200);
    }

    public function todos(){
        $menus = Menu::get();
        return $menus;
    }
    public function listar(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return Menu::with('padre:id,nombre')->whereRaw('UPPER(nombre) LIKE ?', ['%'.$buscar.'%'])
            ->paginate($paginacion);
    }

}
