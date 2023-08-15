<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Role;
use Illuminate\Http\Request;

class MenuRoleController extends Controller
{
    public function mostrarMenus(){
        return Menu::with('menus')->select('id','nombre','slug','icono')
                    ->whereNull('padre_id')
                    ->orderBy('orden','asc')
                    ->get();
    }
    public function mostrarRoleMenus(Request $request)
    {
        //Definimos las reglas de Validación
        $reglas = [
            'role_id' => 'required'
        ];
        //Agregamos Mensajes para las reglas
        $mensajes = [
            'required' => '* Dato Obligatorio'
        ];
        //procesamos la validación
        $this->validate($request,$reglas,$mensajes);

        $role = Role::with('menus')->where('id',$request->role_id)->first();

        return response()->json([
            'role' => $role
        ]);
    }
    public function guardarRoleMenu(Request $request)
    {
        $role = Role::where('id',$request->role_id)->first();

        $role->asignarMenus($request->menu_id);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Menús Asignados Satisfactoriamente'
        ],200);
    }
}
