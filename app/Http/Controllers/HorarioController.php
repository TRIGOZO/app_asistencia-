<?php

namespace App\Http\Controllers;
use App\http\Requests\horario\StoreHorarioRequest;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function store(StoreHorarioRequest $request)
    {
        // $request->validated();
        // $cargo = Cargo::create([
        //     'nombre'    => $request->nombre,
        // ]);

        // return response()->json([
        //     'ok' => 1,
        //     'mensaje' => 'Cargo Registrado satisfactoriamente'
        // ],200);
    }
}
