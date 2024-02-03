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
            $marcacion = Marcacion::where('personal_id',$personal->id)
                            ->where('fecha_hora',$request->fecha)->count();

            if($marcacion==0)
            {
                $marcacion = new Marcacion();
		//$personal = $this->getPersonalData($request->dni);
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
	return false;

    }

    public static function getMarcacionRealByPersonal(Request $request){
        return DB::select("
        SELECT concat(personales.apellido_paterno, ' ',personales.apellido_materno, ', ', 
        personales.nombres) as apenom, personales.numero_dni, marcaciones.fecha_hora as fecha_hora_marcada
        FROM personales
        JOIN marcaciones ON personales.id = marcaciones.personal_id
        WHERE personales.numero_dni = ?
            AND year(marcaciones.fecha_hora) = ?
            AND MONTH(marcaciones.fecha_hora) = ?;
        ",[
            $request->dni,$request->anho,$request->mes
        ]);
    }


    public static function getByPersonal(Request $request){
        return DB::select("
        SELECT horarios.fecha, horarios.hora_entrada, horarios.hora_salida, concat(personales.apellido_paterno, ' ',personales.apellido_materno, ', ', 
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
				(select count(permisos.id) from permisos where personal_id=personales.id and 
                    (
                        CAST(CONCAT(horarios.fecha, ' ', horarios.hora_entrada) AS DATETIME) >= 
                        CAST(CONCAT(permisos.fecha_desde, ' ', permisos.hora_inicio) AS DATETIME)
                    )
                    AND
                    (
                        CAST(CONCAT(horarios.fecha, ' ', horarios.hora_entrada) AS DATETIME) <= 
                        CAST(CONCAT(permisos.fecha_hasta, ' ', permisos.hora_hasta) AS DATETIME)
                    )
            ) > 0
            then 0
            when
                tipo_turnos.id in (1,57,59)
            then 0
            when
                tipo_turnos.id in (6,7,8)
            then
                720 
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
                tipo_turnos.id in (55)
            then
                720   
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
            then (
				select if(count(permisos.id)>0,0, null) from permisos where personal_id=personales.id and 
                    (
                        CAST(CONCAT(horarios.fecha, ' ', horarios.hora_entrada) AS DATETIME) >= 
                        CAST(CONCAT(permisos.fecha_desde, ' ', permisos.hora_inicio) AS DATETIME)
                    )
                    AND
                    (
                        CAST(CONCAT(horarios.fecha, ' ', horarios.hora_entrada) AS DATETIME) <= 
                        CAST(CONCAT(permisos.fecha_hasta, ' ', permisos.hora_hasta) AS DATETIME)
                    )
                )
  
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
        (
            case
            when 
                (
				select count(permisos.id) from permisos where personal_id=personales.id and 
						(
							CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) >= 
							CAST(CONCAT(permisos.fecha_desde, ' ', permisos.hora_inicio) AS DATETIME)
						)
						AND
						(
							CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) <= 
							CAST(CONCAT(permisos.fecha_hasta, ' ', permisos.hora_hasta) AS DATETIME)
						)
                )>0
            then
            0
            when
                tipo_turnos.id in (1,57,59)
            then 0   
            when 
                ROUND(TIMESTAMPDIFF(
                    SECOND,
                    concat(horarios.fecha,' ',horarios.hora_salida),
                    (
                        SELECT min(marcaciones.fecha_hora)
                        FROM marcaciones 
                        WHERE marcaciones.personal_id = personales.id
                            AND horarios.fecha = DATE(marcaciones.fecha_hora)
                            AND (
                                TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
                                AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida
                            )
                    )
                )/60,0) is null
            then (
				select if(count(permisos.id)>0,0, null) from permisos where personal_id=personales.id and 
						(
							CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) >= 
							CAST(CONCAT(permisos.fecha_desde, ' ', permisos.hora_inicio) AS DATETIME)
						)
						AND
						(
							CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) <= 
							CAST(CONCAT(permisos.fecha_hasta, ' ', permisos.hora_hasta) AS DATETIME)
						)
                )
            else 
                ROUND(TIMESTAMPDIFF(
                    SECOND,
                    concat(horarios.fecha,' ',horarios.hora_salida),
                    (
                        SELECT min(marcaciones.fecha_hora)
                        FROM marcaciones 
                        WHERE marcaciones.personal_id = personales.id
                            AND horarios.fecha = DATE(marcaciones.fecha_hora)
                            AND (
                                TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
                                AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida
                            )
                    )
                )/60,0)
        end
        )
        AS diferencia_salida,
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
        LEFT JOIN feriados ON horarios.fecha = feriados.fecha
        WHERE personales.numero_dni = ?
            AND year(horarios.fecha) = ?
            AND MONTH(horarios.fecha) = ?
            AND feriados.fecha is null;
        ",[
            $request->dni,$request->anho,$request->mes
        ]);
    }
    public static function getTardanzasByEstablecimiento(Request $request){
        return DB::select("
        SELECT personales.numero_dni, concat(personales.apellido_paterno, ' ',personales.apellido_materno, ', ', 
        personales.nombres) as apenom, condicion_laborales.nombre as condicion, cargos.nombre as cargo,
        personales.nivel_id as nivel, personales.sueldo,
        sum(
        case
            when
                tipo_turnos.id in (1,57,59)
            then
                0
            when
                tipo_turnos.id in (6,7,8)
            then
                720
              
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
                tipo_turnos.id in (55)
            then
                720   
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
            then (
				select if(count(permisos.id)>0,0, 0) from permisos where personal_id=personales.id and 
                    (
                        CAST(CONCAT(horarios.fecha, ' ', horarios.hora_entrada) AS DATETIME) >= 
                        CAST(CONCAT(permisos.fecha_desde, ' ', permisos.hora_inicio) AS DATETIME)
                    )
                    AND
                    (
                        CAST(CONCAT(horarios.fecha, ' ', horarios.hora_entrada) AS DATETIME) <= 
                        CAST(CONCAT(permisos.fecha_hasta, ' ', permisos.hora_hasta) AS DATETIME)
                    )
                )
        end
        )
             as minutos,
        IF(tipo_trabajador_id=1,sueldo/12000,sueldo/14400) as constante_descuento
        FROM personales
        inner JOIN horario_personals ON personales.id = horario_personals.personal_id
        INNER JOIN horarios ON horario_personals.id = horarios.horario_personal_id    
        INNER JOIN turno_horario on (
                horarios.turno_horario_id=turno_horario.id	
        )
        INNER JOIN condicion_laborales on personales.condicion_laboral_id=condicion_laborales.id
        INNER JOIN cargos on personales.cargo_id=cargos.id
        inner join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
        LEFT JOIN feriados ON horarios.fecha = feriados.fecha
        WHERE personales.establecimiento_id = ?
            AND personales.condicion_laboral_id = ?
            AND year(horarios.fecha) = ?
            AND MONTH(horarios.fecha) = ?
            AND feriados.fecha is null group by (personales.numero_dni);
        ",[
            $request->establecimiento_id,$request->condicion_laboral_id,$request->anho,$request->mes
        ]);        
    }
    public static function getFaltasByPersonal(Request $request){
        return DB::select("
            select horarios.nombredia, horarios.fecha,
            sum(
            case
                when
                    (select count(marcaciones.id) from marcaciones 
                    where 
                        marcaciones.personal_id=horario_personals.personal_id
                        and 
                        date(marcaciones.fecha_hora) = horarios.fecha
                        AND (
                            (
                                TIME(marcaciones.fecha_hora)>= turno_horario.inicioentrada 
                                AND TIME(marcaciones.fecha_hora) <= turno_horario.finentrada
                            )
                            OR (
                                TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
                                AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida        
                            )
                        )
                    )<2
                then
                    (select count(permisos.id)>=1 from permisos where personal_id=horario_personal_id and 
                        (
                            (
                                (
                                    CAST(CONCAT(horarios.fecha, ' ', horarios.hora_entrada) AS DATETIME) >= 
                                    CAST(CONCAT(permisos.fecha_desde, ' ', permisos.hora_inicio) AS DATETIME)
                                )
                                AND
                                (
                                    CAST(CONCAT(horarios.fecha, ' ', horarios.hora_entrada) AS DATETIME) <= 
                                    CAST(CONCAT(permisos.fecha_hasta, ' ', permisos.hora_hasta) AS DATETIME)
                                )
                            )or
                            (
                                (
                                    CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) >= 
                                    CAST(CONCAT(permisos.fecha_desde, ' ', permisos.hora_inicio) AS DATETIME)
                                )
                                AND
                                (
                                    CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) <= 
                                    CAST(CONCAT(permisos.fecha_hasta, ' ', permisos.hora_hasta) AS DATETIME)
                                )
                            )
                        )
                    )

                else
                    1
            end
            )
            as marcaciones_incluidopermisos
            from horarios 
            inner join horario_personals on horarios.horario_personal_id=horario_personals.id
            inner join turno_horario on horarios.turno_horario_id=turno_horario.id
            inner join personales on personales.id=horario_personals.personal_id
            LEFT JOIN feriados ON horarios.fecha = feriados.fecha
            where 
            personales.numero_dni=? and
            year(horarios.fecha)=? and
            month(horarios.fecha)=?
            AND feriados.fecha is null
            group by horarios.fecha, horarios.nombredia having marcaciones_incluidopermisos<2;

        ", [
            $request->dni,$request->anho,$request->mes
        ]);
    }
    public static function getFaltasByEstablecimiento(Request $request){
        // if($request->condicion==0){
        //         return DB::select("
        //         select personales.numero_dni, concat(personales.apellido_paterno, ' ',personales.apellido_materno, ', ', personales.nombres) as apenom,
        //         condicion_laborales.nombre as condicion, cargos.nombre as cargo, personales.nivel_id as nivel,
        //         sum(if(marcaciones<2, 1,0)) as faltas,
        //         personales.sueldo, round(if(personales.tipo_trabajador_id=1,sueldo/25, sueldo/30),2) as sueldo_diario,
        //         (sum(if(marcaciones<2, 1,0))*round(if(personales.tipo_trabajador_id=1,sueldo/25, sueldo/30),2)) as descuentototal
        //         from personales
        //         inner join vistamarcaciones on personales.id=vistamarcaciones.personal_id
        //         inner join condicion_laborales on personales.condicion_laboral_id=condicion_laborales.id
        //         inner join cargos on personales.cargo_id=cargos.id
        //         where establecimiento_id=? and
        //         month(vistamarcaciones.fecha)=? and
        //         year(vistamarcaciones.fecha)=?
        //         group by personales.id having sum(if(marcaciones<2, 1,0))>0
        //     ", [
        //         $request->establecimiento_id,$request->mes,$request->anho
        //     ]);
        // }else{
        //         return DB::select("
        //         select personales.numero_dni, concat(personales.apellido_paterno, ' ',personales.apellido_materno, ', ', personales.nombres) as apenom,
        //         condicion_laborales.nombre as condicion, cargos.nombre as cargo, personales.nivel_id as nivel,
        //         sum(if(marcaciones<2, 1,0)) as faltas,
        //         personales.sueldo, round(if(personales.tipo_trabajador_id=1,sueldo/25, sueldo/30),2) as sueldo_diario,
        //         (sum(if(marcaciones<2, 1,0))*round(if(personales.tipo_trabajador_id=1,sueldo/25, sueldo/30),2)) as descuentototal
        //         from personales
        //         inner join vistamarcaciones on personales.id=vistamarcaciones.personal_id
        //         inner join condicion_laborales on personales.condicion_laboral_id=condicion_laborales.id
        //         inner join cargos on personales.cargo_id=cargos.id
        //         where establecimiento_id=? and
        //         month(vistamarcaciones.fecha)=? and
        //         year(vistamarcaciones.fecha)=? and
        //         personales.condicion_laboral_id=?
        //         group by personales.id having sum(if(marcaciones<2, 1,0))>0
        //     ", [
        //         $request->establecimiento_id,$request->mes,$request->anho, $request->condicion
        //     ]);
        // }

            $query = DB::table('personales')
            ->join('vistamarcaciones', 'personales.id', '=', 'vistamarcaciones.personal_id')
            ->join('condicion_laborales', 'personales.condicion_laboral_id', '=', 'condicion_laborales.id')
            ->join('cargos', 'personales.cargo_id', '=', 'cargos.id')
            ->where('establecimiento_id', $request->establecimiento_id)
            ->whereMonth('vistamarcaciones.fecha', $request->mes)
            ->whereYear('vistamarcaciones.fecha', $request->anho)
            ->groupBy('personales.id')
            ->havingRaw('sum(if(marcaciones < 2, 1, 0)) > 0')
            ->select([
                'personales.numero_dni as numero_dni',
                DB::raw("concat(personales.apellido_paterno, ' ', personales.apellido_materno, ', ', personales.nombres) as apenom"),
                'condicion_laborales.nombre as condicion',
                'cargos.nombre as cargo',
                'personales.nivel_id as nivel',
                DB::raw('sum(if(marcaciones < 2, 1, 0)) as faltas'),
                'personales.sueldo as sueldo',
                DB::raw('round(if(personales.tipo_trabajador_id = 1, sueldo / 25, sueldo / 30), 2) as sueldo_diario'),
                DB::raw('sum(if(marcaciones < 2, 1, 0)) * round(if(personales.tipo_trabajador_id = 1, sueldo / 25, sueldo / 30), 2) as descuentototal'),
            ])->orderBy('personales.apellido_paterno', 'asc');
        
        if ($request->condicion_laboral_id != 0) {
            $query->where('personales.condicion_laboral_id', $request->condicion_laboral_id);
        }
        
        $result = $query->get();
        
        return $result;
    }
    public static function getfaltasporfecha(Request $request){
        $query = DB::table('personales')
        ->join('vistamarcaciones', 'personales.id', '=', 'vistamarcaciones.personal_id')
        ->join('cargos', 'personales.cargo_id', '=', 'cargos.id')
        ->where('personales.establecimiento_id', $request->establecimiento_id)
        ->whereDate('vistamarcaciones.fecha', $request->fecha)
        ->where('vistamarcaciones.marcaciones','<', 2)
        ->select([
            'vistamarcaciones.fecha as fecha',
            'personales.id as id',
            'personales.numero_dni as numero_dni',
            DB::raw("concat(personales.apellido_paterno, ' ', personales.apellido_materno, ', ', personales.nombres) as apenom"),
            'cargos.nombre as cargo',
            'personales.nivel_id as nivel',
            'personales.sueldo as sueldo',
            DB::raw('round(if(personales.tipo_trabajador_id = 1, sueldo / 25, sueldo / 30), 2) as sueldo_diario'),
        ])->orderBy('personales.apellido_paterno', 'asc');
        $result = $query->get();
        return $result;

    }
    public static function reporteHrasExtras(Request $request){
        return DB::select("
        SELECT concat(personales.apellido_paterno, ' ',personales.apellido_materno, ', ', 
        personales.nombres) as apenom, personales.numero_dni,
        sum(
            case
            when 
                (
				select count(permisos.id) from permisos where personal_id=personales.id and 
						(
							CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) >= 
							CAST(CONCAT(permisos.fecha_desde, ' ', permisos.hora_inicio) AS DATETIME)
						)
						AND
						(
							CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) <= 
							CAST(CONCAT(permisos.fecha_hasta, ' ', permisos.hora_hasta) AS DATETIME)
						)
                )>0
            then
            0
            when
                tipo_turnos.id in (1,57,59)
            then 0   
            when 
                ROUND(TIMESTAMPDIFF(
                    SECOND,
                    concat(horarios.fecha,' ',horarios.hora_salida),
                    (
                        SELECT min(marcaciones.fecha_hora)
                        FROM marcaciones 
                        WHERE marcaciones.personal_id = personales.id
                            AND horarios.fecha = DATE(marcaciones.fecha_hora)
                            AND (
                                TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
                                AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida
                            )
                    )
                )/60,0) is null
            then (
					0
                )
            else 
                ROUND(TIMESTAMPDIFF(
                    SECOND,
                    concat(horarios.fecha,' ',horarios.hora_salida),
                    (
                        SELECT min(marcaciones.fecha_hora)
                        FROM marcaciones 
                        WHERE marcaciones.personal_id = personales.id
                            AND horarios.fecha = DATE(marcaciones.fecha_hora)
                            AND (
                                TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
                                AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida
                            )
                    )
                )/60,0)
			end
        )
        AS diferencia_salida
        FROM personales
        inner JOIN horario_personals ON personales.id = horario_personals.personal_id
        INNER JOIN horarios ON horario_personals.id = horarios.horario_personal_id    
        INNER JOIN turno_horario on ( horarios.turno_horario_id=turno_horario.id )
        INNER join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
        LEFT JOIN feriados ON horarios.fecha = feriados.fecha
        WHERE 
			personales.establecimiento_id=?
            AND personales.condicion_laboral_id=?
            and year(horarios.fecha) = ?
            AND MONTH(horarios.fecha) = ?
            AND feriados.fecha is null
            and turno_horario.tipo_turno_id <> 2
		group by personales.numero_dni;
        ",[
            $request->establecimiento_id,$request->condicion_laboral_id,$request->anho,$request->mes
        ]);
    }
}
