<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Usuario\UpdateProfileRequest;
use App\Http\Requests\Usuario\UpdatePasswordRequest;
use App\Http\Requests\Usuario\UpdateUserRequest;
use App\Http\Requests\Usuario\StoreUserRequest;
use App\Models\Personal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(StoreUserRequest $request){
        $personal = Personal::where('numero_dni', $request->numero_dni)->first();
        if($personal){
            $personal->update([
                'nombres'           => $request->nombres,
                'apellido_paterno'  => $request->apellido_paterno,
                'apellido_materno'  => $request->apellido_materno,
                'sexo'              => $request->sexo,
                'telefono'          => $request->telefono,
                'celular'           => $request->celular,
                'email'             => $request->email,
                'profesion_id'      => $request->profesion_id,
                'direccion'         => $request->direccion,
                'establecimiento_id'=> $request->establecimiento_id,
            ]);
        }else{
            $personal = Personal::create([
                'numero_dni'        => $request->numero_dni,
                'nombres'           => $request->nombres,
                'apellido_paterno'  => $request->apellido_paterno,
                'apellido_materno'  => $request->apellido_materno,
                'sexo'              => $request->sexo,
                'telefono'          => $request->telefono,
                'celular'           => $request->celular,
                'email'             => $request->email,
                'profesion_id'      => $request->profesion_id,
                'direccion'         => $request->direccion,
                'establecimiento_id'=> $request->establecimiento_id,
            ]);
        }
        $usuario = User::create([
            'username'          => $request->username,
            'personal_id'       => $personal->id,
            'role_id'           => $request->role_id,
            'establecimiento_id'=> $request->establecimiento_id,
            'password'          => Hash::make($request->numero_dni),
        ]);
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Usuario Registrado satisfactoriamente'
        ],200);
    }
    public function actualizarperfil(UpdateProfileRequest $request){
        $request->validated();
        $usuario = User::find(Auth::user()->id);
        $usuario->username = $request->username;
        $usuario->save();
        $persona = Personal::findOrFail($request->id);
        $persona->fill([
            'nombres'           => $request->nombres,
            'apellido_paterno'  => $request->apellido_paterno,
            'apellido_materno'  => $request->apellido_materno,
            'sexo'              => $request->sexo,
            'fecha_nacimiento'  => $request->fecha_nacimiento,
            'estado_civil_id'   => $request->estado_civil_id,
            'telefono'          => $request->telefono,
            'celular'           => $request->celular,
            'email'             => $request->email,
            'tienehijos'        => $request->tienehijos,
            'profesion_id'      => $request->profesion_id
        ]);
        $persona->save();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro modificado satisfactoriamente'
        ],200);
    }
    public function cambiarclaveperfil(UpdatePasswordRequest $request){
        $request->validated();
        $user = Auth::user();
        if(Hash::check($request->current_password,$user->password)){
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json([
                'ok' => 1,
                'mensaje' => 'Clave Cambiado con Exito'
            ],200);
        }
        else {
            return response()->json([
                'errors' => [
                    'current_password' => [
                        'Contraseña Incorrecta'
                    ]
                ]
            ],422);
        }
    }
    public function show(Request $request){
        $user = User::with('personal:id,nombres,apellido_paterno,apellido_materno,numero_dni,telefono,celular,direccion,email')
        ->where('id', $request->id)->first();
        return $user;
    }
    public function mostrarDatoUsuario(Request $request): User
    {
        $menu = [];
        $usuario=User::with('role:id,nombre')->where('id',$request->id)->first();
        $menus = $usuario->obtenerMenus($usuario->role->id)->toArray();
        array_merge($menus,$menu);
        $usuario->menus = $menus;

        return $usuario;
    }
    public function update(UpdateUserRequest $request){
        $user = User::findOrFail($request->id);
        $personal = Personal::where('id', $user->id)->first();
        
        if($personal){
            $personal->update([
                'nombres'           => $request->nombres,
                'apellido_paterno'  => $request->apellido_paterno,
                'apellido_materno'  => $request->apellido_materno,
                'numero_dni'        => $request->numero_dni,
                'sexo'              => $request->sexo,
                'celular'           => $request->celular,
                'email'             => $request->email,
                'direccion'         => $request->direccion,
                'establecimiento_id' => $request->establecimiento_id,
            ]);
            $personal->save();
        }else{
            $personal = Personal::create([
                'numero_dni'        => $request->numero_dni,
                'nombres'           => $request->nombres,
                'apellido_paterno'  => $request->apellido_paterno,
                'apellido_materno'  => $request->apellido_materno,
                'sexo'              => $request->sexo,
                'telefono'          => $request->telefono,
                'celular'           => $request->celular,
                'email'             => $request->email,
                'profesion_id'      => $request->profesion_id,
                'direccion'         => $request->direccion,
                'establecimiento_id'=> $request->establecimiento_id,
            ]);
        }
        $user->update([
            'username'           => $request->username,
            'establecimiento_id' => $request->establecimiento_id,
            'role_id'            => $request->role_id,
            'personal_id'        => $personal->id,
        ]);
        $user->save();


        return response()->json([
            'ok' => 1,
            'mensaje' => 'Se guardo Exito'
        ],200);
    }
    public function habilitados(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return User::with([
            'personal:id,numero_dni,apellido_paterno,apellido_materno,nombres,sexo,establecimiento_id',
            'establecimiento:id,nombre'
        ])
        ->where(function($query) use($buscar) {
            $query->whereRaw("upper(username) like ?", ['%'.strtoupper($buscar).'%'])
                ->orWhereHas('personal', function($q) use($buscar){
                    $q->whereRaw('upper(numero_dni) like ?', ['%'.strtoupper($buscar).'%'])
                        ->orWhereRaw("upper(concat(apellido_paterno,' ',apellido_materno)) like ?", ['%'.strtoupper($buscar).'%'])
                        ->orWhereRaw("upper(nombres) like ?", ['%'.strtoupper($buscar).'%']);
                });
        })
        ->paginate($paginacion);
    }
    public function eliminados(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return User::with([
            'personal:id,numero_dni,apellido_paterno,apellido_materno,nombres,sexo'
        ])
        ->where(function($query) use($buscar) {
            $query->whereRaw("upper(username) like ?", ['%'.strtoupper($buscar).'%'])
                ->orWhereHas('personal', function($q) use($buscar){
                    $q->whereRaw('upper(numero_dni) like ?', ['%'.strtoupper($buscar).'%'])
                        ->orWhereRaw("upper(concat(apellido_paterno,' ',apellido_materno)) like ?", ['%'.strtoupper($buscar).'%'])
                        ->orWhereRaw("upper(nombres) like ?", ['%'.strtoupper($buscar).'%']);
                });
        })->onlyTrashed()
        ->paginate($paginacion);
    }
    public function todos(Request $request)
    {
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return User::with([
            'personal:id,numero_dni,apellido_paterno,apellido_materno,nombres,sexo'
        ])
        ->where(function($query) use($buscar) {
            $query->whereRaw("upper(username) like ?", ['%'.strtoupper($buscar).'%'])
                ->orWhereHas('personal', function($q) use($buscar){
                    $q->whereRaw('upper(numero_dni) like ?', ['%'.strtoupper($buscar).'%'])
                        ->orWhereRaw("upper(concat(apellido_paterno,' ',apellido_materno)) like ?", ['%'.strtoupper($buscar).'%'])
                        ->orWhereRaw("upper(nombres) like ?", ['%'.strtoupper($buscar).'%']);
                });
        })->withTrashed()
        ->paginate($paginacion);
    }
    public function destroy(Request $request){
        $user = User::where('id', $request->id)
                    ->withTrashed()
                    ->first()
        ;
        $user->forceDelete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Usuario eliminado satisfactoriamente'
        ],200);
    }
    public function eliminarpermanente(Request $request){
        $user = User::where('id', $request->id)
                    ->withTrashed()
                    ->first()
        ;
        $user->forceDelete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Usuario Eliminado Permanentemente'
        ],200);
    }
}
