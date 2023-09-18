<?php

namespace App\Http\Controllers;

use App\Models\Marcacion;
use Illuminate\Http\Request;

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
}
