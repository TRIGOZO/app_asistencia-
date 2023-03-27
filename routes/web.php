<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SistemaAsistenciaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::post('login',[AuthController::class,'login']);
Route::get('/', function () {
    return view('app');
});
Route::group(['middleware' => ['auth:sanctum']],function(){
    Route::post('/logout',[AuthController::class,'logout']);
    Route::get('/usuario-session-data',[UserController::class,'mostrarDatoUsuario']);
    Route::get('/obtener-menu-slug',[MenuController::class,'mostrarmenuslug']);
});

Route::get('/{path}',[SistemaAsistenciaController::class,'index'])->where('path','.*');







