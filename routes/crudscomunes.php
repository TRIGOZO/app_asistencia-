<?php
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\CondicionLaboralController;
use App\Http\Controllers\EstablecimientoController;
use App\Http\Controllers\FeriadoController;
use App\Http\Controllers\MicroRedController;
use App\Http\Controllers\NivelController;
use App\Http\Controllers\OficinaController;
use App\Http\Controllers\ProfesionController;
use App\Http\Controllers\RedController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TipoGuardiaController;
use App\Http\Controllers\TipoNivelController;
use App\Http\Controllers\TipoPermisoController;
use App\Http\Controllers\TipoTrabajadorController;
use App\Http\Controllers\TipoTurnoController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'personal', 'middleware' => 'auth'], function () {
    Route::get('obtener', [PersonalController::class, 'show']);
    Route::get('obtener-detalle', [PersonalController::class, 'mostrarpersonadetalle']);
    Route::get('estados-civiles', [PersonalController::class, 'estados_civiles']);
    Route::get('todos', [PersonalController::class, 'todos']);
    Route::get('mostrar', [PersonalController::class, 'show']);
    Route::post('actualizar', [PersonalController::class, 'update']);
    Route::post('eliminar', [PersonalController::class, 'destroy']);
    Route::post('guardar', [PersonalController::class, 'store']);;
    Route::get('listar', [PersonalController::class, 'listar']);    
});


Route::group(['prefix' => 'cargo', 'middleware' => 'auth'], function () {
    Route::get('todos', [CargoController::class, 'todos']);
    Route::get('mostrar',[CargoController::class,'show']);
    Route::post('actualizar',[CargoController::class,'update']);
    Route::post('eliminar',[CargoController::class,'destroy']);
    Route::post('guardar', [CargoController::class, 'store']);;
    Route::get('listar',[CargoController::class,'listar']);
});

Route::group(['prefix' => 'establecimiento', 'middleware' => 'auth'], function () {
    Route::get('todos', [EstablecimientoController::class, 'todos']);
    Route::get('mostrar', [EstablecimientoController::class, 'show']);
    Route::post('actualizar', [EstablecimientoController::class, 'update']);
    Route::post('eliminar', [EstablecimientoController::class, 'destroy']);
    Route::post('guardar', [EstablecimientoController::class, 'store']);
    Route::get('listar', [EstablecimientoController::class, 'listar']);
});

Route::group(['prefix' => 'oficina', 'middleware' => 'auth'], function () {
    Route::get('todos', [OficinaController::class, 'todos']);
    Route::get('mostrar', [OficinaController::class, 'show']);
    Route::post('actualizar', [OficinaController::class, 'update']);
    Route::post('eliminar', [OficinaController::class, 'destroy']);
    Route::post('guardar', [OficinaController::class, 'store']);
    Route::get('listar', [OficinaController::class, 'listar']);
});

Route::group(['prefix' => 'red', 'middleware' => 'auth'], function () {
    Route::get('todos', [RedController::class, 'todos']);
    Route::get('mostrar', [RedController::class, 'show']);
    Route::post('actualizar', [RedController::class, 'update']);
    Route::post('eliminar', [RedController::class, 'destroy']);
    Route::post('guardar', [RedController::class, 'store']);
    Route::get('listar', [RedController::class, 'listar']);
});

Route::group(['prefix' => 'tipo-nivel', 'middleware' => 'auth'], function () {
    Route::get('todos', [TipoNivelController::class, 'todos']);
    Route::get('mostrar', [TipoNivelController::class, 'show']);
    Route::post('actualizar', [TipoNivelController::class, 'update']);
    Route::post('eliminar', [TipoNivelController::class, 'destroy']);
    Route::post('guardar', [TipoNivelController::class, 'store']);
    Route::get('listar', [TipoNivelController::class, 'listar']);
});

Route::group(['prefix' => 'tipo-trabajador', 'middleware' => 'auth'], function () {
    Route::get('todos', [TipoTrabajadorController::class, 'todos']);
    Route::get('mostrar', [TipoTrabajadorController::class, 'show']);
    Route::post('actualizar', [TipoTrabajadorController::class, 'update']);
    Route::post('eliminar', [TipoTrabajadorController::class, 'destroy']);
    Route::post('guardar', [TipoTrabajadorController::class, 'store']);
    Route::get('listar', [TipoTrabajadorController::class, 'listar']);
});

Route::group(['prefix' => 'tipo-permiso', 'middleware' => 'auth'], function () {
    Route::get('todos', [TipoPermisoController::class, 'todos']);
    Route::get('mostrar', [TipoPermisoController::class, 'show']);
    Route::post('actualizar', [TipoPermisoController::class, 'update']);
    Route::post('eliminar', [TipoPermisoController::class, 'destroy']);
    Route::post('guardar', [TipoPermisoController::class, 'store']);
    Route::get('listar', [TipoPermisoController::class, 'listar']);
});

Route::group(['prefix' => 'feriado', 'middleware' => 'auth'], function () {
    Route::get('todos', [FeriadoController::class, 'todos']);
    Route::get('mostrar', [FeriadoController::class, 'show']);
    Route::post('actualizar', [FeriadoController::class, 'update']);
    Route::post('eliminar', [FeriadoController::class, 'destroy']);
    Route::post('guardar', [FeriadoController::class, 'store']);
    Route::get('listar', [FeriadoController::class, 'listar']);
});

Route::group(['prefix' => 'profesion', 'middleware' => 'auth'], function () {
    Route::get('todos', [ProfesionController::class, 'todos']);
    Route::get('mostrar', [ProfesionController::class, 'show']);
    Route::post('actualizar', [ProfesionController::class, 'update']);
    Route::post('eliminar', [ProfesionController::class, 'destroy']);
    Route::post('guardar', [ProfesionController::class, 'store']);
    Route::get('listar', [ProfesionController::class, 'listar']);
});

Route::group(['prefix' => 'condicion-laboral', 'middleware' => 'auth'], function () {
    Route::get('todos', [CondicionLaboralController::class, 'todos']);
    Route::get('mostrar', [CondicionLaboralController::class, 'show']);
    Route::post('actualizar', [CondicionLaboralController::class, 'update']);
    Route::post('eliminar', [CondicionLaboralController::class, 'destroy']);
    Route::post('guardar', [CondicionLaboralController::class, 'store']);
    Route::get('listar', [CondicionLaboralController::class, 'listar']);
});

Route::group(['prefix' => 'tipo-turno', 'middleware' => 'auth'], function () {
    Route::get('todos', [TipoTurnoController::class, 'todos']);
    Route::get('mostrar', [TipoTurnoController::class, 'show']);
    Route::post('actualizar', [TipoTurnoController::class, 'update']);
    Route::post('eliminar', [TipoTurnoController::class, 'destroy']);
    Route::post('guardar', [TipoTurnoController::class, 'store']);
    Route::get('listar', [TipoTurnoController::class, 'listar']);
});

Route::group(['prefix' => 'tipo-guardia', 'middleware' => 'auth'], function () {
    Route::get('todos', [TipoGuardiaController::class, 'todos']);
    Route::get('mostrar', [TipoGuardiaController::class, 'show']);
    Route::post('actualizar', [TipoGuardiaController::class, 'update']);
    Route::post('eliminar', [TipoGuardiaController::class, 'destroy']);
    Route::post('guardar', [TipoGuardiaController::class, 'store']);
    Route::get('listar', [TipoGuardiaController::class, 'listar']);
});

Route::group(['prefix' => 'micro-red', 'middleware' => 'auth'], function () {
    Route::get('todos', [MicroRedController::class, 'todos']);
    Route::get('mostrar', [MicroRedController::class, 'show']);
    Route::post('actualizar', [MicroRedController::class, 'update']);
    Route::post('eliminar', [MicroRedController::class, 'destroy']);
    Route::post('guardar', [MicroRedController::class, 'store']);
    Route::get('listar', [MicroRedController::class, 'listar']);
});

Route::group(['prefix' => 'rol', 'middleware' => 'auth'], function () {
    Route::get('todos', [RoleController::class, 'todos']);
    Route::get('mostrar', [RoleController::class, 'show']);
    Route::post('actualizar', [RoleController::class, 'update']);
    Route::post('eliminar', [RoleController::class, 'destroy']);
    Route::post('guardar', [RoleController::class, 'store']);
    Route::get('listar', [RoleController::class, 'listar']);
});

Route::group(['prefix' => 'nivel', 'middleware' => 'auth'], function () {
    Route::get('todos', [NivelController::class, 'todos']);
    Route::get('mostrar', [NivelController::class, 'show']);
    Route::post('actualizar', [NivelController::class, 'update']);
    Route::post('eliminar', [NivelController::class, 'destroy']);
    Route::post('guardar', [NivelController::class, 'store']);
    Route::get('listar', [NivelController::class, 'listar']);
});
