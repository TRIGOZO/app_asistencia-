<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
trait LoginTrait
{
    public function validarLogin(LoginRequest $request){
        $request->validated();
        $credenciales = ['username' => $request->username, 'password' => $request->password, 'es_activo' => 1];
        $user = User::where('username',$request->username)->first();
        if($user){
            if(Hash::check($request->password,$user->password)){
                if(auth()->attempt($credenciales)){
                    $user = auth()->user();
                    $usuario = User::where('id',$user->id)->first();
                    $success['user'] = $usuario->id;
                    // $permiso = [];
                    // $menu = [];
                    // foreach($usuario->roles as $role)
                    // {
                    //     $permisos = $usuario->obtenerPermisos($role->id)->toArray();
                    //     array_merge($permisos,$permiso);

                    //     $menus = $usuario->obtenerMenus($role->id)->toArray();
                    //     array_merge($menus,$menu);
                    // }
                    // $success['user']['permisos'] = $permisos;
                    // $success['user']['menus'] = $menus;
                    $success=JWT::encode($success,env('VITE_SECRET_KEY'), 'HS256' );
                    return response()->json($success,200);

                } else {
                    return response()->json([
                        'errors' => ['username' => 'Usuario Suspendido']
                    ],422);
                }
            }
            else {
                return response()->json([
                    'errors' => ['password' => 'Contraseña Incorrecta']
                ],422);
            }
        }
        else {
            return response([
                'errors' => [ 'username' => 'Nombre de Usuario no válido']
            ], 422);
        }
    }
}
