<?php

use App\Http\Controllers\MarcacionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::prefix('attendances')->group(function() {
//     Route::get('/',[MarcacionController::class,'obtenerMarcaciones']);
// });
Route::group(['prefix' => 'attendances'], function () {
    Route::get('/',[MarcacionController::class,'obtenerMarcaciones']);
    Route::get('verificar-dni',[MarcacionController::class,'verificarDniPersonal']);
    Route::post('store',[MarcacionController::class,'guardarMarcacionPersonal']);
});