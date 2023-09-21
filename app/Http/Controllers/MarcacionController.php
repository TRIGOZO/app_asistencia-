<?php

namespace App\Http\Controllers;

use App\Models\Marcacion;
use Illuminate\Http\Request;
use App\Http\Requests\marcaciones\StoreMarcacionRequest;
use App\Http\Requests\marcaciones\UpdateMarcacionRequest;
use App\Models\Personal;

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
        $marcacion = $this->marcacion_model->saveMarcacion($request);
        
        if($marcacion)
        {
            return response()->json([
                'ok' => 1,
                'mensaje' => 'Marcación registrada satisfactoriamente'
            ]);
        }

        return response()->json([
            'ok' => 0,
            'mensaje' => 'Hubo un error'
        ]);
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
}
