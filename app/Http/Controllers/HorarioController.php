<?php

namespace App\Http\Controllers;
use App\Http\Requests\Horario\StoreHorarioRequest;
use App\Models\Horario;
use App\Models\HorarioTurno;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function store(StoreHorarioRequest $request)
    {

        $fechaInicio = Carbon::parse($request->fecha_desde);
        $fechaFin = Carbon::parse($request->fecha_hasta);


        $registro = HorarioTurno::where('id', $request->tipo_turno_id)->first();
        $fechasGeneradas = [];

        if(!$registro){
            return response()->json([
                'ok' => 0,
                'mensaje' => 'No se Cargo el Horario al Turno'
            ],200);
        }

        $nro=1;

        while ($fechaInicio->lte($fechaFin)) {
            $fechasGeneradas[] = $fechaInicio->toDateString().'  -  '.$fechaInicio->dayOfWeek;

            Horario::create([
                'nro' => $nro,
                'personal_id' => $request->personal_id,
                'tipo_turno_id' => $request->tipo_turno_id,
                'fecha' => $fechaInicio->toDateString(),
                'dia' => $fechaInicio->dayOfWeek,
                'hora_entrada' => $registro->horaentrada,
                'hora_salida' => $registro->horasalida,
                'total_horas' => $registro->totalhoras,
                'tolerancia_antes' => $registro->toleranciaantes,
                'tolerancia_despues' => $registro->toleranciadespues,
                'es_lactancia' => $request->es_lactancia == true ? 'SI' : 'NO',
            ]);

  
            $fechaInicio->addDay(); // Agrega un día

        }

        return $fechasGeneradas;



        // $cargo = Cargo::create([
        //     'nombre'    => $request->nombre,
        // ]);

        // return response()->json([
        //     'ok' => 1,
        //     'mensaje' => 'Cargo Registrado satisfactoriamente'
        // ],200);
    }
}
