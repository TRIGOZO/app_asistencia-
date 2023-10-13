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
    public function store(StoreHorarioRequest $request){
        $finicio = Carbon::parse($request->fecha_desde);
        $fechaInicio = $finicio;
        $fechaFin = Carbon::parse($request->fecha_hasta);
        $registros = HorarioTurno::where('tipo_turno_id', $request->tipo_turno_id)->get();
        if($registros->isEmpty()){
            return response()->json([
                'ok' => 0,
                'mensaje' => 'No se encontraron horarios para el turno especificado'
            ], 200);
        }
        if($fechaInicio==$fechaFin){
            return response()->json([
                'ok' => 0,
                'mensaje' => 'El intervalo de Fechas debe ser mayor a 1'
            ],200);
        }
        $horariospersonal=[];
        foreach($registros as $row){
            $horario = HorarioPersonal::with('turno_horario:id,dialunes,diamartes,diamiercoles,diajueves,diaviernes,diasabado,diadomingo')->create([
                'personal_id'        => $request->personal_id,
                'turno_horario_id'   => $row->id,
                'tolerancia_antes'   => $row->toleranciaantes,
                'tolerancia_despues' => $row->toleranciadespues,
                'es_lactancia'       => $request->es_lactancia == true ? 1 : 0
            ]);
            $horario->load('turno_horario');
            $horariospersonal[] = $horario;
        }
        $fechaInicio = $finicio;
        $nro=1;
        $horarios=[];
        while ($fechaInicio->lte($fechaFin)) {
            foreach($horariospersonal as $row){
                if ($this->esDiaHabilitado($fechaInicio->dayOfWeek, $row)) {
                    //$fecha = Carbon::create($anoActual, $request->mes_numero, 1);
                    $horarios[] = [
                        'nro' => $nro,
                        'horario_personal_id' => $row->id,
                        'fecha' => $fechaInicio->toDateString(),
                        'dia' => $fechaInicio->dayOfWeek,
                        'hora_entrada' => $row->turno_horario->horaentrada,
                        'hora_salida' => $row->turno_horario->horasalida,
                        'total_horas' => $row->turno_horario->totalhoras,
                    ];
                    $nro++;
                }
            }
            $fechaInicio->addDay();
        }
        Horario::insert($horarios);
        return response()->json([
            'ok' => 1,
            'horarios' => $horarios,
            'mensaje' => 'GENERADO SATISFACTORIAMENTE'
        ],200);
    }
    private function esDiaHabilitado($dayOfWeek, $row)
    {
        switch ($dayOfWeek) {
            case 0: return $row->turno_horario->diadomingo == 1;
            case 1: return $row->turno_horario->dialunes == 1;
            case 2: return $row->turno_horario->diamartes == 1;
            case 3: return $row->turno_horario->diamiercoles == 1;
            case 4: return $row->turno_horario->diajueves == 1;
            case 5: return $row->turno_horario->diaviernes == 1;
            case 6: return $row->turno_horario->diasabado == 1;
            default: return false;
        }
    }
    public function guardarHorarioAsistencial(StoreHorarioAsistencialRequest $request){
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
