<?php

namespace App\Http\Controllers;
use App\Http\Requests\horarioturno\StoreHorarioTurnoRequest;
use App\Http\Requests\horarioturno\UpdateHorarioTurnoRequest;
use App\Models\HorarioTurno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HorarioTurnoController extends Controller
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
    public function store(StoreHorarioTurnoRequest $request)
    {
        $request->validated();
        $horarioturno = HorarioTurno::create([
            'tipo_turno_id' => $request->tipo_turno_id,
            'horaentrada' => $request->horaentrada,
            'horasalida' => $request->horasalida,
            'toleranciaantes' => $request->toleranciaantes,
            'toleranciadespues' => $request->toleranciadespues,
            'inicioentrada' => $request->inicioentrada,
            'finentrada' => $request->finentrada,
            'iniciosalida' => $request->iniciosalida,
            'finsalida' => $request->finsalida,
            'dialunes' => $request->dialunes,
            'diamartes' => $request->diamartes,
            'diamiercoles' => $request->diamiercoles,
            'diajueves' => $request->diajueves,
            'diaviernes' => $request->diaviernes,
            'diasabado' => $request->diasabado,
            'diadomingo' => $request->diadomingo,
            'totalhoras' => $request->totalhoras,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Horario Registrado satisfactoriamente'
        ],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {      
        $horario = HorarioTurno::with('tipo_turno:id,nombre')
        ->where('tipo_turno_id', $request->id)->first();
        return $horario;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHorarioTurnoRequest $request)
    {

        $horario = HorarioTurno::findOrFail($request->id);

        $horario->update([
            'tipo_turno_id' => $request->tipo_turno_id,
            'horaentrada' => $request->horaentrada,
            'horasalida' => $request->horasalida,
            'toleranciaantes' => $request->toleranciaantes,
            'toleranciadespues' => $request->toleranciadespues,
            'inicioentrada' => $request->inicioentrada,
            'finentrada' => $request->finentrada,
            'iniciosalida' => $request->iniciosalida,
            'finsalida' => $request->finsalida,
            'dialunes' => $request->dialunes,
            'diamartes' => $request->diamartes,
            'diamiercoles' => $request->diamiercoles,
            'diajueves' => $request->diajueves,
            'diaviernes' => $request->diaviernes,
            'diasabado' => $request->diasabado,
            'diadomingo' => $request->diadomingo,
            'totalhoras' => $request->totalhoras,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Horario modificado satisfactoriamente'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
