<?php
namespace App\Http\Traits;

use App\Models\Establecimiento;
use App\Models\Marcacion;
use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait HorarioTrait
{
    public static function getAllPersonalesConTurnos($request){
$profesion_id=$request->profesion_id;
        return DB::table('personales as p')
        ->join('dia_mes as dm', DB::raw('1'), '=', DB::raw('1'))
        ->select(
            'p.id',
            'p.numero_dni',
            DB::raw("CONCAT(p.apellido_paterno, ' ', p.apellido_materno, ' ', p.nombres) as apellidos_nombres"),
            'p.tipo_trabajador_id as tipo_trabajador_id',
            'p.profesion_id as profesion_id',
            'p.establecimiento_id as establecimiento_id',
            DB::raw("false as modificado"),
            DB::Raw("0 as total_horas"),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 1 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura)
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d1
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 2 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d2
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 3 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d3
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 4 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d4
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 5 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d5
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 6 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d6
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 7 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d7
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 8 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d8
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 9 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d9
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 10 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d10
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 11 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d11
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 12 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d12
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 13 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d13
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 14 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d14
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 15 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d15
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 16 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d16
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 17 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d17
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 18 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d18
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 19 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d19
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 20 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d20
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 21 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d21
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 22 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d22
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 23 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d23
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 24 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d24
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 25 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d25
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 26 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d26
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 27 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d27
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 28 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d28
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 29 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d29
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 30 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d30
            "),
            DB::raw("
                MAX(
                    CASE 
                        WHEN dm.dia = 31 THEN
                            CASE
                                WHEN (
                                    SELECT COUNT(horarios.turno_horario_id) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                ) = 2 THEN 'MT'
                                ELSE (
                                    SELECT MAX(tipo_turnos.abreviatura) 
                                    FROM horarios
                                    JOIN horario_personals ON horarios.horario_personal_id = horario_personals.id
                                    JOIN turno_horario ON horarios.turno_horario_id = turno_horario.id
                                    JOIN tipo_turnos ON turno_horario.tipo_turno_id = tipo_turnos.id
                                    WHERE horario_personals.personal_id = p.id 
                                        AND YEAR(horarios.fecha) = ".$request->anio."
                                        AND MONTH(horarios.fecha) = ".$request->mes_numero."
                                        AND DAY(horarios.fecha) = dm.dia
                                )
                            END
                    END
                ) as d31
            ")

        )
        ->where('p.tipo_trabajador_id', '=', $request->tipo_trabajador_id)
        ->when($profesion_id != '', function ($query) use ($profesion_id) {
            return $query->where('p.profesion_id', $profesion_id);
        })
        ->where('p.establecimiento_id', '=', $request->establecimiento_id)
        ->where('p.es_activo', '=', 1)
        ->groupBy('p.id', 'p.numero_dni', 'p.apellido_paterno', 'p.apellido_materno', 'p.nombres')
        ->orderBy('p.apellido_paterno', 'ASC')
        ->orderBy('p.apellido_materno', 'ASC')
        ->orderBy('p.nombres', 'ASC')
        ->get();
    }




}
