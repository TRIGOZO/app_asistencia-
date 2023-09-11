<?php
namespace App\Http\Traits;

use App\Models\Marcacion;
use Illuminate\Http\Request;

trait MarcacionTrait
{
    public function getAllMarcaciones(){
        $marcaciones = Marcacion::with([
            'personal:id,numero_dni','nombres','apellido_paterno','apellido_materno',
            'establecimiento:id,nombre'
        ])->get();

        return response()->json($marcaciones,200);
    }
}