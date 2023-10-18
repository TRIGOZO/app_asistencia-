<?php
namespace App\Http\Traits;

use App\Models\Establecimiento;
use App\Models\Marcacion;
use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait MarcacionTrait
{
    public function getAllMarcaciones(){
        $marcaciones = Marcacion::with([
            'personal:id,numero_dni,nombres,apellido_paterno,apellido_materno',
            'establecimiento:id,nombre'
        ])->get();

        return $marcaciones;
    }

    public function getAllPersonalByEstablecimiento(string $establecimiento) {
        $establecimiento = Establecimiento::select('id')->where('codigo',$establecimiento)->first();
        $personales = null;
        if($establecimiento) {
            $personales = Personal::select('');
        }
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
    public static function getByPersonal(Request $request){
        return DB::select("
        SELECT horarios.hora_entrada, horarios.hora_salida, concat(personales.apellido_paterno, ' ',personales.apellido_materno, ', ', 
        personales.nombres) as apenom, personales.numero_dni,
        tipo_turnos.nombre as turno, 
        (
            SELECT min(marcaciones.fecha_hora)
            FROM marcaciones 
            WHERE marcaciones.personal_id = personales.id
                AND horarios.fecha = DATE(marcaciones.fecha_hora)
                AND (
                    TIME(marcaciones.fecha_hora)>= turno_horario.inicioentrada 
                    AND TIME(marcaciones.fecha_hora) <= turno_horario.finentrada
                )
        ) as fecha_hora_entrada_marcada,
        case
            when 
                time((SELECT min(time(marcaciones.fecha_hora))
                    FROM marcaciones 
                    WHERE marcaciones.personal_id = personales.id
                        AND horarios.fecha = DATE(marcaciones.fecha_hora)
                        AND (
                            TIME(marcaciones.fecha_hora)>= turno_horario.inicioentrada 
                            AND TIME(marcaciones.fecha_hora) <= turno_horario.finentrada
                        )
                    ))< horarios.hora_entrada
            then 0
            when 
                minute((SELECT min(time(marcaciones.fecha_hora))
                    FROM marcaciones 
                    WHERE marcaciones.personal_id = personales.id
                        AND horarios.fecha = DATE(marcaciones.fecha_hora)
                        AND (
                            TIME(marcaciones.fecha_hora)>= turno_horario.inicioentrada 
                            AND TIME(marcaciones.fecha_hora) <= turno_horario.finentrada
                        )
                    ) - horarios.hora_entrada) >= 30
            then 480
            when 
                minute((SELECT min(time(marcaciones.fecha_hora))
                    FROM marcaciones 
                    WHERE marcaciones.personal_id = personales.id
                        AND horarios.fecha = DATE(marcaciones.fecha_hora)
                        AND (
                            TIME(marcaciones.fecha_hora)>= turno_horario.inicioentrada 
                            AND TIME(marcaciones.fecha_hora) <= turno_horario.finentrada
                        )
                    ) - horarios.hora_entrada) >= 21
            then 30
            when 
                minute((SELECT min(time(marcaciones.fecha_hora))
                    FROM marcaciones 
                    WHERE marcaciones.personal_id = personales.id
                        AND horarios.fecha = DATE(marcaciones.fecha_hora)
                        AND (
                            TIME(marcaciones.fecha_hora)>= turno_horario.inicioentrada 
                            AND TIME(marcaciones.fecha_hora) <= turno_horario.finentrada
                        )
                    ) - horarios.hora_entrada) >= 11
            then 20
            when 
                minute((SELECT min(time(marcaciones.fecha_hora))
                    FROM marcaciones 
                    WHERE marcaciones.personal_id = personales.id
                        AND horarios.fecha = DATE(marcaciones.fecha_hora)
                        AND (
                            TIME(marcaciones.fecha_hora)>= turno_horario.inicioentrada 
                            AND TIME(marcaciones.fecha_hora) <= turno_horario.finentrada
                        )
                    ) - horarios.hora_entrada) >=0
            then 0
            when 
                minute((SELECT min(time(marcaciones.fecha_hora))
                    FROM marcaciones 
                    WHERE marcaciones.personal_id = personales.id
                        AND horarios.fecha = DATE(marcaciones.fecha_hora)
                        AND (
                            TIME(marcaciones.fecha_hora)>= turno_horario.inicioentrada 
                            AND TIME(marcaciones.fecha_hora) <= turno_horario.finentrada
                        )
                    ) - horarios.hora_entrada) is null
            then 0
        end

             as diferencia_entrada,
        (
            SELECT min(marcaciones.fecha_hora)
            FROM marcaciones 
            WHERE marcaciones.personal_id = personales.id
                AND horarios.fecha = DATE(marcaciones.fecha_hora)
                AND (
                    TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
                    AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida
                )
        ) as fecha_hora_salida_marcada,
        minute((SELECT min(time(marcaciones.fecha_hora))
            FROM marcaciones 
            WHERE marcaciones.personal_id = personales.id
                AND horarios.fecha = DATE(marcaciones.fecha_hora)
                AND (
                    TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
                    AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida
                )
            ) - horarios.hora_salida)
             as diferencia_salida,
        (				
            minute((SELECT min(time(marcaciones.fecha_hora))
            FROM marcaciones 
            WHERE marcaciones.personal_id = personales.id
                AND horarios.fecha = DATE(marcaciones.fecha_hora)
                AND (
                    TIME(marcaciones.fecha_hora)>= turno_horario.inicioentrada 
                    AND TIME(marcaciones.fecha_hora) <= turno_horario.finentrada
                )
            ) - horarios.hora_entrada)
            + 
            minute((SELECT min(time(marcaciones.fecha_hora))
            FROM marcaciones 
            WHERE marcaciones.personal_id = personales.id
                AND horarios.fecha = DATE(marcaciones.fecha_hora)
                AND (
                    TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
                    AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida
                )
            ) - horarios.hora_salida)                
        ) as total_diferencia
        FROM personales
        inner JOIN horario_personals ON personales.id = horario_personals.personal_id
        INNER JOIN horarios ON horario_personals.id = horarios.horario_personal_id    
        INNER JOIN turno_horario on (
                horarios.turno_horario_id=turno_horario.id	
        )
        inner join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
        WHERE personales.numero_dni = ?
            AND year(horarios.fecha) = ?
            AND MONTH(horarios.fecha) = ?;
        ",[
            $request->dni,$request->anho,$request->mes
        ]);
    }
}