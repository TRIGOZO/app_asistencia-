<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function mostrarDatoUsuario(Request $request): User
    {

        // Auth::user()->




        // $usuario = User::with([
        //     'roles' => function($query){
        //         $query->select('roles.id', 'roles.nombre','roles.slug');
        //     }])->join('personas as per','per.id','=','users.persona_id')
        //     ->join('tipo_documentos as tp','tp.id','=','per.tipo_documento_id')
        //     ->join('sexos as se','se.id','=','per.sexo_id')
        //     ->select(
        //         "users.id",'users.name','users.email', 'users.persona_id',
        //         'per.nombres','per.apellido_paterno','per.apellido_materno',
        //         'per.telefono','per.direccion','per.numero_documento',
        //         'per.tipo_documento_id','tp.nombre_corto as tipo_documento',
        //         'per.sexo_id','se.nombre as sexo','users.foto'
        //     )
        // ->where('users.id',$request->id)->first();


        // $permiso = [];
        // $menu = [];
        // foreach($usuario->roles as $role)
        // {
        //     $permisos = $usuario->obtenerPermisos($role->id)->toArray();
        //     array_merge($permisos,$permiso);

        //     $menus = $usuario->obtenerMenus($role->id)->toArray();
        //     array_merge($menus,$menu);

        // }
        // $usuario->menus = $menus;
        // $usuario->permisos = $permisos;

        $menu = [];
        $usuario=User::with('role:id,nombre')->where('id',$request->id)->first();
        $menus = $usuario->obtenerMenus($usuario->role->id)->toArray();
        array_merge($menus,$menu);
        $usuario->menus = $menus;

        return $usuario;
    }
}
