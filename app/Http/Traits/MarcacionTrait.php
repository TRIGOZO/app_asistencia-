<?php
namespace App\Http\Traits;

use App\Models\Marcacion;
use App\Models\Personal;
use Illuminate\Http\Request;

trait MarcacionTrait
{
    public function getAllMarcaciones(){
        $marcaciones = Marcacion::with([
            'personal:id,numero_dni,nombres,apellido_paterno,apellido_materno',
            'establecimiento:id,nombre'
        ])->get();

        return $marcaciones;
    }

    public function getVerificarDniPersonal(string $dni) {
        $personal_count = Personal::select('id')->where('numero_dni',$dni)->first();
        return $personal_count->id;
    }

    public function getPersonalData(string $dni) {
        return Personal::where('numero_dni',$dni)->first();
    }

    public function saveMarcacion(Request $request)
    {
        $personal = $this->getPersonalData($request->dni);
        if($personal) {
            $marcacion = new Marcacion();
            $personal = $this->getPersonalData($request->dni);
            $marcacion->personal_id = $personal->id ?? null;
            $marcacion->establecimiento_id = $personal->establecimiento_id ?? null;
            $marcacion->fecha_hora = $request->fecha;
            $marcacion->tipo = $request->tipo;
            $marcacion->serial = $request->serial;
            $marcacion->ip = $request->ip;
            $marcacion->save();
    
            return $marcacion;
        }

    }
}