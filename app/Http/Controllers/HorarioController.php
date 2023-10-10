<?php

namespace App\Http\Controllers;
use App\Http\Requests\Horario\StoreHorarioRequest;
use App\Http\Requests\Horario\StoreHorarioAsistencialRequest;
use App\Models\Horario;
use App\Models\HorarioPersonal;
use App\Models\HorarioTurno;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function obtenerHorariosPersonal(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;
        return HorarioPersonal::with([
                'personal:id,numero_dni,nombres,apellido_paterno,apellido_materno',
                'tipo_turno:id,nombre'
                ])
            ->where(function($query) use($buscar) {
                $query->whereHas('personal', function($q) use($buscar){
                        $q->whereRaw('upper(numero_dni) like ?', ['%'.strtoupper($buscar).'%'])
                            ->orWhereRaw("upper(concat(apellido_paterno,' ',apellido_materno)) like ?", ['%'.strtoupper($buscar).'%'])
                            ->orWhereRaw("upper(nombres) like ?", ['%'.strtoupper($buscar).'%']);

                });
            })
            ->paginate($paginacion);
    }
    public function cargarConstanteDscto(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        return HorarioPersonal::with([
                'personal:id,numero_dni,nombres,apellido_paterno,apellido_materno',
                'tipo_turno:id,nombre'
                ])
            ->where(function($query) use($buscar) {
                $query->whereHas('personal', function($q) use($buscar){
                        $q->whereRaw('upper(numero_dni) like ?', ['%'.strtoupper($buscar).'%'])
                            ->orWhereRaw("upper(concat(apellido_paterno,' ',apellido_materno)) like ?", ['%'.strtoupper($buscar).'%'])
                            ->orWhereRaw("upper(nombres) like ?", ['%'.strtoupper($buscar).'%']);

                });
            })
            ->get();
    }
    public function eliminarHorarioPersonal(Request $request){
        $nivel = HorarioPersonal::where('id', $request->id)->first();
        $nivel->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro eliminado satisfactoriamente'
        ],200);
    }
    public function eliminarDetHorario(Request $request){
        $horario = Horario::where('id', $request->id)->first();
        $horario->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Registro eliminado satisfactoriamente'
        ],200);
    }    
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

        $nro=1;
        if($fechaInicio==$fechaFin){
            return response()->json([
                'ok' => 0,
                'mensaje' => 'El intervalo de Fechas debe ser mayor a 1'
            ],200);
        }

        while ($fechaInicio->lte($fechaFin)) {
            $estado=false;
            switch ($fechaInicio->dayOfWeek) {
                case 0:
                    if($registro->diadomingo==1){
                        $estado=true;
                    }
                    break;
                case 1:
                    if($registro->dialunes==1){
                        $estado=true;
                    }
                    break;
                case 2:
                    if($registro->diamartes==1){
                        $estado=true;
                    }
                    break;
                case 3:
                    if($registro->diamiercoles==1){
                        $estado=true;
                    }
                    break;
                case 4:
                    if($registro->diajueves==1){
                        $estado=true;
                    }
                    break;
                case 5:
                    if($registro->diaviernes==1){
                        $estado=true;
                    }
                    break;
                case 6:
                    if($registro->diasabado==1){
                        $estado=true;
                    }
                    break;
            }
            if($estado==true){
                $horario = new Horario;
                $horario->nro = $nro;
                $horario->horario_personal_id = $horariopersonal->id;
                $horario->fecha = $fechaInicio->toDateString();
                $horario->dia = $fechaInicio->dayOfWeek;
                $horario->hora_entrada = $registro->horaentrada;
                $horario->hora_salida = $registro->horasalida;
                $horario->total_horas = $registro->totalhoras;
                $horario->save();              
            }
            $nro++;
            $fechaInicio->addDay();
        }
        return response()->json([
            'ok' => 1,
            'horario_personal_id' => $horariopersonal->id,
            'mensaje' => 'GENERADO SATISFACTORIAMENTE'
        ],200);
    }
    public function guardarHorarioAsistencial(StoreHorarioAsistencialRequest $request){
        // if($request->validated()){
        //     return response()->json([
        //         'errors'    => $request->validated()
        //     ],422);
        // }
        //$fechaInicio = Carbon::parse($request->fecha_desde);
        $fechaActual = Carbon::now();
        foreach($request->regdias as $dia){
            $fecha = $fechaActual->setDay($dia['dia'])->setMonth($request->mes);
            $registro = HorarioTurno::with('tipo_turno:id,abreviatura,nombre')
            ->whereHas('tipo_turno', function ($query) use ($dia) {
                $query->where('abreviatura', $dia['rol']);
            })
            ->first();
            //return $dia['rol'];
            $horario = new Horario;
            $horario->nro = $dia['dia'];
            $horario->fecha = $fecha;
            $horario->dia = $fecha->dayOfWeek;
            $horario->hora_entrada = $registro->horaentrada;
            $horario->hora_salida = $registro->horasalida;
            $horario->total_horas = $registro->totalhoras;
            $horario->save();    
        }
        return response()->json([
            'ok' => 1,
            'mensaje' => 'GUARDADO SATISFACTORIAMENTE'
        ],200);
    }



    
    public function show(Request $request){
        $horario = Horario::where('horario_personal_id', $request->id)->get();
        return $horario;
    }
}
