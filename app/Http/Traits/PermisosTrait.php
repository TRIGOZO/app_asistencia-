<?php
namespace App\Http\Traits;

use App\Models\Establecimiento;
use App\Models\Marcacion;
use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait PermisosTrait
{
    public static function getPermisosSinGoce(Request $request){
        if($request->condicion_laboral_id==0){
                return DB::select("
                SELECT
                personales.numero_dni AS DNI,
                CONCAT(personales.apellido_paterno, ' ', personales.apellido_materno, ' ', personales.nombres) AS apenom,
                establecimientos.nombre as establecimiento,
                condicion_laborales.nombre AS condicion,
                cargos.nombre AS cargo,
                personales.nivel_id AS nivel,
                CONCAT(permisos.FECHA_DESDE, ' ', permisos.HORA_INICIO) AS fecha_inicio,
                CONCAT(permisos.FECHA_HASTA, ' ', permisos.HORA_hasta) AS fecha_final,
                TIMESTAMPDIFF(
                    MINUTE,
                    CONCAT(permisos.FECHA_DESDE, ' ', permisos.HORA_INICIO),
                    CONCAT(permisos.FECHA_HASTA, ' ', permisos.HORA_hasta)
                ) - 
                90 * (DATEDIFF(DATE_FORMAT(permisos.FECHA_HASTA, '%Y-%m-%d'), DATE_FORMAT(permisos.FECHA_DESDE, '%Y-%m-%d')) + 1) AS minutos_sin_goce,
                personales.sueldo AS SUELDO,
                ROUND(((personales.sueldo / (30 * 8 * 60)) * ((TIMESTAMPDIFF(
                    MINUTE,
                    CONCAT(permisos.FECHA_DESDE, ' ', permisos.HORA_INICIO),
                    CONCAT(permisos.FECHA_HASTA, ' ', permisos.HORA_hasta)
                ) - 
                90 * (DATEDIFF(DATE_FORMAT(permisos.FECHA_HASTA, '%Y-%m-%d'), DATE_FORMAT(permisos.FECHA_DESDE, '%Y-%m-%d')) + 1)))), 2) AS descuento
            FROM
                permisos
            INNER JOIN
                tipo_permisos ON tipo_permisos.id = permisos.tipo_permiso_id
            INNER JOIN
                establecimientos ON establecimientos.id = permisos.establecimiento_id
            INNER JOIN
                personales ON personales.id = permisos.personal_id
            INNER JOIN
                condicion_laborales ON condicion_laborales.id = personales.condicion_laboral_id
            INNER JOIN
                cargos ON cargos.id = personales.cargo_id
            WHERE
                permisos.establecimiento_id=? and
                permisos.fecha_desde>=? and permisos.fecha_hasta<=? and
                tipo_permisos.id=13
            ORDER BY
                personales.apellido_paterno;
                ",[
                    $request->establecimiento_id,$request->fecha_desde,$request->fecha_hasta
                ]);
        }else{
            return DB::select("
            SELECT
            personales.numero_dni AS DNI,
            CONCAT(personales.apellido_paterno, ' ', personales.apellido_materno, ' ', personales.nombres) AS apenom,
            establecimientos.nombre as establecimiento,
            condicion_laborales.nombre AS condicion,
            cargos.nombre AS cargo,
            personales.nivel_id AS nivel,
            CONCAT(permisos.FECHA_DESDE, ' ', permisos.HORA_INICIO) AS fecha_inicio,
            CONCAT(permisos.FECHA_HASTA, ' ', permisos.HORA_hasta) AS fecha_final,
            TIMESTAMPDIFF(
                MINUTE,
                CONCAT(permisos.FECHA_DESDE, ' ', permisos.HORA_INICIO),
                CONCAT(permisos.FECHA_HASTA, ' ', permisos.HORA_hasta)
            ) - 
            90 * (DATEDIFF(DATE_FORMAT(permisos.FECHA_HASTA, '%Y-%m-%d'), DATE_FORMAT(permisos.FECHA_DESDE, '%Y-%m-%d')) + 1) AS minutos_sin_goce,
            personales.sueldo AS SUELDO,
            ROUND(((personales.sueldo / (30 * 8 * 60)) * ((TIMESTAMPDIFF(
                MINUTE,
                CONCAT(permisos.FECHA_DESDE, ' ', permisos.HORA_INICIO),
                CONCAT(permisos.FECHA_HASTA, ' ', permisos.HORA_hasta)
            ) - 
            90 * (DATEDIFF(DATE_FORMAT(permisos.FECHA_HASTA, '%Y-%m-%d'), DATE_FORMAT(permisos.FECHA_DESDE, '%Y-%m-%d')) + 1)))), 2) AS descuento
        FROM
            permisos
        INNER JOIN
            tipo_permisos ON tipo_permisos.id = permisos.tipo_permiso_id
        INNER JOIN
            establecimientos ON establecimientos.id = permisos.establecimiento_id
        INNER JOIN
            personales ON personales.id = permisos.personal_id
        INNER JOIN
            condicion_laborales ON condicion_laborales.id = personales.condicion_laboral_id
        INNER JOIN
            cargos ON cargos.id = personales.cargo_id
        WHERE
            permisos.establecimiento_id=? and
            condicion_laborales.id = ? and
            permisos.fecha_desde>=? and permisos.fecha_hasta<=? and
            tipo_permisos.id=13
        ORDER BY
            personales.apellido_paterno;
            ",[
                $request->establecimiento_id,$request->condicion_laboral_id,$request->fecha_desde,$request->fecha_hasta
            ]);            
        }

    }
    public static function getPermisosParticulares(Request $request){
        if($request->condicion_laboral_id==0){
            return DB::select("
            SELECT
                personales.numero_dni AS DNI,
                CONCAT(personales.apellido_paterno, ' ', personales.apellido_materno, ' ', personales.nombres) AS apenom,
                condicion_laborales.nombre AS condicion,
                establecimientos.nombre as establecimiento,
                cargos.nombre AS cargo,
                personales.nivel_id AS nivel,
                CONCAT(permisos.FECHA_DESDE, ' ', permisos.HORA_INICIO) AS fecha_inicio,
                CONCAT(permisos.FECHA_HASTA, ' ', permisos.HORA_hasta) AS fecha_final,
                TIMESTAMPDIFF(MINUTE, CONCAT(permisos.FECHA_DESDE, ' ', permisos.HORA_INICIO), CONCAT(permisos.FECHA_HASTA, ' ', permisos.HORA_hasta)) AS minutos_permiso,
                personales.sueldo AS SUELDO,
                ROUND(TIMESTAMPDIFF(MINUTE, CONCAT(permisos.FECHA_DESDE, ' ', permisos.HORA_INICIO), CONCAT(permisos.FECHA_HASTA, ' ', permisos.HORA_hasta)) * (personales.sueldo / (30 * 8 * 60)), 2) AS descuento
            FROM
                permisos
            INNER JOIN
                tipo_permisos ON tipo_permisos.id = permisos.tipo_permiso_id
            INNER JOIN
                establecimientos ON establecimientos.id = permisos.establecimiento_id
            INNER JOIN
                personales ON personales.id = permisos.personal_id
            INNER JOIN
                condicion_laborales ON condicion_laborales.id = personales.condicion_laboral_id
            INNER JOIN
                cargos ON cargos.id = personales.cargo_id
            WHERE
                permisos.establecimiento_id=? and
                permisos.fecha_desde>=? and permisos.fecha_hasta<=? and
                tipo_permisos.id=2
            ORDER BY
                personales.apellido_paterno;
            ",[
                $request->establecimiento_id,$request->fecha_desde,$request->fecha_hasta
            ]);
        }else{
            return DB::select("
                SELECT
                personales.numero_dni AS DNI,
                CONCAT(personales.apellido_paterno, ' ', personales.apellido_materno, ' ', personales.nombres) AS apenom,
                condicion_laborales.nombre AS condicion,
                establecimientos.nombre as establecimiento,
                cargos.nombre AS cargo,
                personales.nivel_id AS nivel,
                CONCAT(permisos.FECHA_DESDE, ' ', permisos.HORA_INICIO) AS fecha_inicio,
                CONCAT(permisos.FECHA_HASTA, ' ', permisos.HORA_hasta) AS fecha_final,
                TIMESTAMPDIFF(MINUTE, CONCAT(permisos.FECHA_DESDE, ' ', permisos.HORA_INICIO), CONCAT(permisos.FECHA_HASTA, ' ', permisos.HORA_hasta)) AS minutos_permiso,
                personales.sueldo AS SUELDO,
                ROUND(TIMESTAMPDIFF(MINUTE, CONCAT(permisos.FECHA_DESDE, ' ', permisos.HORA_INICIO), CONCAT(permisos.FECHA_HASTA, ' ', permisos.HORA_hasta)) * (personales.sueldo / (30 * 8 * 60)), 2) AS descuento
            FROM
                permisos
            INNER JOIN
                tipo_permisos ON tipo_permisos.id = permisos.tipo_permiso_id
            INNER JOIN
                establecimientos ON establecimientos.id = permisos.establecimiento_id
            INNER JOIN
                personales ON personales.id = permisos.personal_id
            INNER JOIN
                condicion_laborales ON condicion_laborales.id = personales.condicion_laboral_id
            INNER JOIN
                cargos ON cargos.id = personales.cargo_id
            WHERE
                permisos.establecimiento_id=? and
                condicion_laborales.id = ? and
                permisos.fecha_desde>=? and permisos.fecha_hasta<=? and
                tipo_permisos.id=2
            ORDER BY
                personales.apellido_paterno;
            ",[
                $request->establecimiento_id,$request->condicion_laboral_id,$request->fecha_desde,$request->fecha_hasta
            ]);
        }        
    }


}