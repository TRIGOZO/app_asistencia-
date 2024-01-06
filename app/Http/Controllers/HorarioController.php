<?php

namespace App\Http\Controllers;
use App\Http\Requests\Horario\StoreHorarioRequest;
use App\Http\Requests\Horario\StoreHorarioAsistencialRequest;
use App\Models\Horario;
use App\Models\HorarioPersonal;
use App\Models\HorarioTurno;
use App\Models\Personal;
use App\Models\TipoTrabajador;
use App\Models\TipoTurno;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HorarioController extends Controller
{
    public function __construct()
    {
        setlocale(LC_TIME, 'es_ES.utf8');
        
    }
    public function obtenerHorariosPersonal(Request $request){
        $buscar = mb_strtoupper($request->buscar);
        $paginacion = $request->paginacion;

        $horariopersonal = HorarioPersonal::with([
            'personal:id,numero_dni,nombres,apellido_paterno,apellido_materno,establecimiento_id',
            'personal.establecimiento:id,nombre',
            'user:id,username,personal_id',
        ])
        ->whereHas('personal', function($q) use ($buscar) {
            $q->where(function($query) use ($buscar) {
                $query->whereRaw('upper(numero_dni) like ?', ['%'.strtoupper($buscar).'%'])
                    ->orWhereRaw("upper(concat(apellido_paterno,' ',apellido_materno)) like ?", ['%'.strtoupper($buscar).'%'])
                    ->orWhereRaw("upper(nombres) like ?", ['%'.strtoupper($buscar).'%']);
            });            
            if (Auth::user()->role_id == 2) { // si es admin
                $q->where('establecimiento_id', Auth::user()->establecimiento_id);
            }
        })
        ->orderBy('created_at', 'desc')
        ->limit(60) 
        ->paginate($paginacion);


        return $horariopersonal;
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
    public function generarHorario($horarioturno){

    }
    public function store(StoreHorarioRequest $request){//administrativo
        $finicio = Carbon::parse($request->fecha_desde);
        $fechaInicio = $finicio;
        $fechaFin = Carbon::parse($request->fecha_hasta);
        $tipoturno = TipoTurno::find($request->tipo_turno_id);
        if($tipoturno->abreviatura=='MT'){
            $registros = HorarioTurno::with('tipo_turno:id,abreviatura')
            ->whereHas('tipo_turno', function ($query){
                $query->whereIn('abreviatura', ['M', 'T']);
            })->get();
        }else{
            $registros = HorarioTurno::where('tipo_turno_id', $request->tipo_turno_id)->get();
        }
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
        $horariopersonal = HorarioPersonal::Create([
            'personal_id'       => $request->personal_id,
            'user_id'           => Auth::user()->id,
            'fecha_desde'       => $fechaInicio,
            'fecha_hasta'       => $fechaFin,
            'es_lactancia'       => $request->es_lactancia == true ? 1 : 0
        ]);
        $horarios=[];
        while ($fechaInicio->lte($fechaFin)) {
            foreach($registros as $row){
                if ($this->esDiaHabilitado($fechaInicio->dayOfWeek, $row)) {
                    $nombreDia = $fechaInicio->formatLocalized('%A');
                    $reghorario = Horario::with(['turno_horario:id', 'turno_horario.tipo_turno,id,abreviatura'])
                    ->create([
                        'nombredia' => $nombreDia,
                        'horario_personal_id' => $horariopersonal->id,
                        'turno_horario_id'    => $row->id,
                        'fecha' => $fechaInicio->toDateString(),
                        'dia' => $fechaInicio->dayOfWeek,
                        'hora_entrada' => $row->horaentrada,
                        'hora_salida' => $row->horasalida,
                        'total_horas' => $row->totalhoras,
                    ]);
                    $reghorario->load(['turno_horario:id,tipo_turno_id', 'turno_horario.tipo_turno:id,abreviatura']);
                    $horarios[]=$reghorario;
                }
            }
            $fechaInicio->addDay();
        }
        // Horario::insert($horarios);
        return response()->json([
            'ok' => 1,
            'horarios' => $horarios,
            'mensaje' => 'GENERADO SATISFACTORIAMENTE'
        ],200);
    }
    public function cargarHorariosMasivo(Request $request){
        $request->validate([
            'establecimiento_id' => 'required',
        ], [
            'required' => 'Selecciona el establecimiento',
        ]);
        $idtipotrabajador = TipoTrabajador::where('nombre', 'Administrativo')->value('id');
        $administrativos = Personal::where('tipo_trabajador_id', $idtipotrabajador)
        ->where('establecimiento_id', $request->establecimiento_id)
        ->get();
        $anio = Carbon::now()->year;
        $fechaInicio = Carbon::create($anio, $request->mes, 1);
        $fechaFin = Carbon::create($anio, $request->mes, 1)->endOfMonth();
        $registros = HorarioTurno::with('tipo_turno:id,abreviatura')
        ->whereHas('tipo_turno', function ($query){
            $query->whereIn('abreviatura', ['M', 'T']);
        })->get();
        foreach($administrativos as $rowadministrativo){
            $horariopersonal = HorarioPersonal::Create([
                'personal_id'       => $rowadministrativo->id,
                'user_id'           => 1,
                'fecha_desde'       => $fechaInicio,
                'fecha_hasta'       => $fechaFin,
            ]);
            $fecha = $fechaInicio->copy();
            while ($fecha->lte($fechaFin)) {
                foreach($registros as $row){
                    if ($this->esDiaHabilitado($fecha->dayOfWeek, $row)) {
                        $nombreDia = $fecha->formatLocalized('%A');
                        Horario::create([
                            'nombredia' => $nombreDia,
                            'horario_personal_id' => $horariopersonal->id,
                            'turno_horario_id'    => $row->id,
                            'fecha' => $fecha->toDateString(),
                            'dia' => $fecha->dayOfWeek,
                            'hora_entrada' => $row->horaentrada,
                            'hora_salida' => $row->horasalida,
                            'total_horas' => $row->totalhoras,
                        ]);
                        usleep(1000);
                    }
                }
                $fecha->addDay();
            }            
        }
        return response()->json([
            'ok' => 1,
            'mensaje' => 'GENERADO SATISFACTORIAMENTE'
        ],200);
    }
    private function esDiaHabilitado($dayOfWeek, $horarioturno)
    {
        switch ($dayOfWeek) {
            case 0: return $horarioturno->diadomingo == 1;
            case 1: return $horarioturno->dialunes == 1;
            case 2: return $horarioturno->diamartes == 1;
            case 3: return $horarioturno->diamiercoles == 1;
            case 4: return $horarioturno->diajueves == 1;
            case 5: return $horarioturno->diaviernes == 1;
            case 6: return $horarioturno->diasabado == 1;
            default: return false;
        }
    }
    public function guardarHorarioAsistencial(Request $request){
        $personal = $request->personal;
        $datosGenerales = $request->datosGenerales;
        $fechaInicio = Carbon::create($datosGenerales['anio'], $datosGenerales['mes_numero'], 1);
        $fechaFin = $fechaInicio->copy()->endOfMonth(); 
        $personal_id=$personal['id'];

        $horariopersonal = HorarioPersonal::where('personal_id', $personal_id)
        ->whereMonth('fecha_desde', $datosGenerales['mes_numero'])
        ->whereYear('fecha_desde', $datosGenerales['anio'])
        ->first();
    
        if(!$horariopersonal){
            $horariopersonal = HorarioPersonal::Create([
                'personal_id'       => $personal['id'],
                'user_id'           => Auth::user()->id,
                'fecha_desde'       => $fechaInicio,
                'fecha_hasta'       => $fechaFin,
            ]);
        }
        while ($fechaInicio->lte($fechaFin)) {
            $horarioExistente = Horario::with('horario_personal:id,personal_id')
            ->where('fecha', $fechaInicio->toDateString())
            ->whereHas('horario_personal', function ($query) use ($personal_id) {
                $query->where('personal_id', $personal_id);
            })
            ->first();
        
            if ($horarioExistente) {
                Horario::where('horario_personal_id', $horariopersonal->id)
                ->where('fecha', $fechaInicio->toDateString())
                ->delete();
            }


            $turno = $personal['d'.intval($fechaInicio->format('d'))];
            $registros = HorarioTurno::with('tipo_turno:id,abreviatura,nombre');
            if ($turno == 'MT') {
                $registros->whereHas('tipo_turno', function ($query) {
                    $query->whereIn('abreviatura', ['M', 'T']);
                });
            } else {
                $registros->whereHas('tipo_turno', function ($query) use ($turno) {
                    $query->where('abreviatura', $turno);
                });
            }
            $registros = $registros->get();
            $nombreDia = $fechaInicio->formatLocalized('%A');
            foreach($registros as $row){
                $reghorario = Horario::create([
                    'nombredia' => $nombreDia,
                    'horario_personal_id' => $horariopersonal->id,
                    'turno_horario_id'    => $row->id,
                    'fecha' => $fechaInicio->toDateString(),
                    'dia' => $fechaInicio->dayOfWeek,
                    'hora_entrada' => $row->horaentrada,
                    'hora_salida' => $row->horasalida,
                    'total_horas' => $row->totalhoras,
                ]);
            }
            $fechaInicio->addDay();
        }
        return response()->json([
            'ok' => 1,
            'mensaje' => 'GUARDADO SATISFACTORIAMENTE'
        ],200);
    }

    public function show(Request $request){
        $horario = Horario::with(['turno_horario:id,tipo_turno_id', 'turno_horario.tipo_turno:id,abreviatura'])
        ->where('horario_personal_id', $request->id)->get();
        return $horario;
    }
}
