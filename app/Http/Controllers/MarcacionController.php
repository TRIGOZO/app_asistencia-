<?php

namespace App\Http\Controllers;

use App\Http\Requests\marcaciones\StoreDatRequest;
use App\Http\Requests\marcaciones\StoreMarcacionRequest;
use Exception;
use App\Models\Marcacion;
use Illuminate\Http\Request;
use App\Http\Requests\marcaciones\UpdateMarcacionRequest;
use App\Http\Requests\marcacionesvshorario\BuscarMarcacionesvsHorarioRequest;
use App\Models\Personal;
use Illuminate\Support\Facades\DB;

class MarcacionController extends Controller
{
    private $marcacion_model;

    public function __construct() {
        $this->marcacion_model = new Marcacion();
    }

    public function obtenerMarcaciones() {
        $marcaciones = $this->marcacion_model->getAllMarcaciones();
        return response()->json($marcaciones, 200);
    }

    public function verificarDniPersonal(Request $request) {
        $personal_count = $this->marcacion_model->getVerificarDniPersonal($request->dni);
        if($personal_count > 0 )
        {
            return response($personal_count,200);
        }
        return 0;
    }

    public function guardarMarcacionPersonal(Request $request)
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(0);
	try{

        	$marcacion = $this->marcacion_model->saveMarcacion($request);
        
       		if($marcacion!==false )
	        {
            		return response()->json([
		                'ok' => 1,
		                'mensaje' => 'Marcación registrada satisfactoriamente'
            		]);
        	}

		if($marcacion == false){
			return response()->json([
				'ok' => 0,
				'mensaje' => 'Marcación ya registradada y/o no existe'
			]);
		}
	} catch(Exception $ex){
        	return response()->json([
	        	    'ok' => 0,
        	   	 'mensaje' =>$ex->getMessage()
		]);
	}
    }
    public function store(StoreMarcacionRequest $request)
    {
        $request->validated();
        $personal=Personal::where('numero_dni', $request->numero_dni)->first();
        $marcacion = Marcacion::create([
            'personal_id'   => $personal->id,
            'establecimiento_id' => $request->establecimiento_id,
            'fecha_hora' => $request->fecha_hora,
            'tipo' => $request->tipo,
            'serial' => $request->serial,
            'ip' => $request->ip,
        ]);

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Marcacion Registrado satisfactoriamente'
        ],200);
    }
    public function marcacionesFecha(Request $request){
        $paginacion = $request->paginacion;
        $marcaciones = Marcacion::with('personal:id,numero_dni,nombres,apellido_paterno,apellido_materno')
        ->whereDate('fecha_hora', '=', date('Y-m-d'))
        ->paginate($paginacion);
        return $marcaciones;


    }
    public function update(UpdateMarcacionRequest $request)
    {
        $request->validated();

        $marcacion = Marcacion::where('id',$request->id)->first();

        $marcacion->personal_id   = $request->personal_id;
        $marcacion->establecimiento_id = $request->establecimiento_id;
        $marcacion->fecha_hora = $request->fecha_hora;
        $marcacion->tipo = $request->tipo;
        $marcacion->serial = $request->serial;
        $marcacion->ip = $request->ip;

        $marcacion->save();

        return response()->json([
            'ok' => 1,
            'mensaje' => 'Nivel modificado satisfactoriamente'
        ],200);
    }
    public function destroy(Request $request)
    {
        $marcacion = Marcacion::where('id', $request->id)->first();
        $marcacion->delete();
        return response()->json([
            'ok' => 1,
            'mensaje' => 'Cargo eliminado satisfactoriamente'
        ],200);
    }
    public function importarData(StoreDatRequest $request){
        $file = $request->file('archivo');
        if ($file) {
            $archivo = file($file->path());
            $cantidad_filas = count($archivo);
            $i=0;
            foreach($archivo as $line_num=>$linea){
                if($i<=$cantidad_filas-2){
                    $dni = str_pad(trim(substr($linea, 1, 8)), 8, '0', STR_PAD_LEFT);
                    $fecha = substr($linea, 10, 19);
                    $existente = Marcacion::where([
                        'personal_id' => Personal::where('numero_dni', $dni)->value('id'),
                        'fecha_hora'  => $fecha,
                    ])->exists();
                    if (!$existente) {
                        Marcacion::firstOrCreate([
                            'personal_id'           => Personal::where('numero_dni', $dni)->value('id'),
                            'establecimiento_id'    => $request->establecimiento_id,
                            'fecha_hora'            => $fecha,
                            'serial'                => 'AF4C172960193',
                            'ip'                    => '192.168.2.252',
                        ]);
                        $i++;
                    }
                }
            }
            return response()->json([
                'ok' => 1,
                'mensaje' => ($i).' Registros Insertados'
            ],200);
        }
    }
    public function cargarMarcacionVsHorario(BuscarMarcacionesvsHorarioRequest $request){

        return Marcacion::getByPersonal($request);


        // $marcaciones = DB::table('marcaciones')
        // ->select([
        //     'marcaciones.id',
        //     DB::raw('DATE(marcaciones.fecha_hora) as fecha'),
        //     'personales.numero_dni',
        //     'personales.nombres',
        //     'personales.apellido_paterno',
        //     'personales.apellido_materno',
        //     DB::raw("concat(personales.apellido_paterno,' ',personales.apellido_materno,' ',personales.nombres) as apenom"),
        //     'personales.sueldo',
        //     'marcaciones.personal_id',
        //     'marcaciones.establecimiento_id',
        //     DB::raw('TIME(marcaciones.fecha_hora) as hora_marcada'),
        //     'marcaciones.tipo',
        //     'marcaciones.serial',
        //     'marcaciones.ip',
        //     'horarios.hora_entrada as hora_entrada',
        //     'horarios.hora_salida',
        //     DB::raw('COALESCE(TIMEDIFF(TIME(marcaciones.fecha_hora), IF(marcaciones.tipo = "Entrada", horarios.hora_entrada, horarios.hora_salida)), "00:00:00") AS diferencia'),
        //     'horario_personals.id'
        // ])
        // ->join('personales', 'marcaciones.personal_id', '=', 'personales.id')
        // ->join('horario_personals', 'personales.id', '=', 'horario_personals.personal_id')
        // ->leftJoin('horarios', function ($join) {
        //     $join->on(DB::raw('DATE(marcaciones.fecha_hora)'), '=', 'horarios.fecha')
        //         ->on('horario_personals.id', '=', 'horarios.horario_personal_id');
        // })
        // ->where('personales.numero_dni', $request->dni)
        // ->whereMonth('marcaciones.fecha_hora', $request->mes)
        // ->get();
        //return $marcaciones;
    }
    public function reporteTardanza(Request $request){
        return Marcacion::getTardanzasByEstablecimiento($request);
    }
    public function faltas(Request $request){
        
        return Marcacion::getFaltasByPersonal($request);
    }
    public function reporteFaltas(Request $request){
        return Marcacion::getFaltasByEstablecimiento($request);
    } 
    public function reporteFaltasxFecha(Request $request){
        return Marcacion::getfaltasporfecha($request);
    }
}
