<?php

namespace App\Http\Controllers;
use App\Http\Requests\Horario\StoreHorarioRequest;
use App\Models\Horario;
use App\Models\HorarioPersonal;
use App\Models\HorarioTurno;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function store(StoreHorarioRequest $request)
    {
        $fechaInicio = Carbon::parse($request->fecha_desde);
        $fechaFin = Carbon::parse($request->fecha_hasta);
        $registro = HorarioTurno::where('tipo_turno_id', $request->tipo_turno_id)->first();
        if(!$registro){
            return response()->json([
                'ok' => 0,
                'mensaje' => 'No se Cargo el Horario al Turno'
            ],200);
        }
        $horariopersonal = HorarioPersonal::create([
            'personal_id'   => $request->personal_id,
            'tipo_turno_id' => $request->tipo_turno_id,
            'tolerancia_antes' => $registro->toleranciaantes,
            'tolerancia_despues' => $registro->toleranciadespues,
            'es_lactancia' => $request->es_lactancia == true ? 1 : 0
        ]);


        $fechasGeneradas = [];
        $nro=1;
        while ($fechaInicio->lte($fechaFin)) {
            $fechasGeneradas[] = $fechaInicio->toDateString().'  -  '.$fechaInicio->dayOfWeek;
            $horario = Horario::create([
                'nro' => $nro,
                'horario_personal_id' => $horariopersonal->id,
                'fecha' => $fechaInicio->toDateString(),
                'dia' => $fechaInicio->dayOfWeek,
                'hora_entrada' => $registro->horaentrada,
                'hora_salida' => $registro->horasalida,
                'total_horas' => $registro->totalhoras
            ]);
            $nro++;
            $fechaInicio->addDay();
        }
        return response()->json([
            'ok' => 1,
            'horario_personal_id' => $horariopersonal->id,
            'mensaje' => 'GENERADO SATISFACTORIAMENTE'
        ],200);
    }
    public function show(Request $request){
        $horario = Horario::where('horario_personal_id', $request->id)->get();
        return $horario;
    }
}
