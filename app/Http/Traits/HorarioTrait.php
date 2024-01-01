<?php
namespace App\Http\Traits;

use App\Models\Establecimiento;
use App\Models\Marcacion;
use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait HorarioTrait
{
    public static function getAllPersonalesConTurnos($ano, $mes, $tipo_trabajador_id, $profesion_id, $establecimiento_id){
        return DB::select("
        select p.id,p.numero_dni,  concat(p.apellido_paterno,' ',p.apellido_materno,' ',p.nombres) as apellidos_nombres, p.tipo_trabajador_id as tipo_trabajador_id,
        p.profesion_id as profesion_id, p.establecimiento_id as establecimiento_id, 
        max(
        CASE 
            WHEN 
            dm.dia = 1 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d1,
        max(
        CASE 
            WHEN 
            dm.dia = 2 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d2,
        max(
        CASE 
            WHEN 
            dm.dia = 3 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d3,
        max(
        CASE 
            WHEN 
            dm.dia = 4 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d4,
        max(
        CASE 
            WHEN 
            dm.dia = 5 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d5,
        max(
        CASE 
            WHEN 
            dm.dia = 6 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d6,
        max(
        CASE 
            WHEN 
            dm.dia = 7 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d7,
        max(
        CASE 
            WHEN 
            dm.dia = 8 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d8,
        max(
        CASE 
            WHEN 
            dm.dia = 9 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d9,
        max(
        CASE 
            WHEN 
            dm.dia = 10 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d10,
        max(
        CASE 
            WHEN 
            dm.dia = ".$mes." 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d11,
        max(
        CASE 
            WHEN 
            dm.dia = 12 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d12,
        max(
        CASE 
            WHEN 
            dm.dia = 13 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d13,
        max(
        CASE 
            WHEN 
            dm.dia = 14 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d14,
        max(
        CASE 
            WHEN 
            dm.dia = 15 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d15,
        max(
        CASE 
            WHEN 
            dm.dia = 16 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d16,
        max(
        CASE 
            WHEN 
            dm.dia = 17 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d17,
        max(
        CASE 
            WHEN 
            dm.dia = 18 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d18,
        max(
        CASE 
            WHEN 
            dm.dia = 19 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d19,
        max(
        CASE 
            WHEN 
            dm.dia = 20 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d20,
        max(
        CASE 
            WHEN 
            dm.dia = 21 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d21,
        max(
        CASE 
            WHEN 
            dm.dia = 22 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d22,
        max(
        CASE 
            WHEN 
            dm.dia = 23 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d23,
        max(
        CASE 
            WHEN 
            dm.dia = 24 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d24,
        max(
        CASE 
            WHEN 
            dm.dia = 25 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d25,
        max(
        CASE 
            WHEN 
            dm.dia = 26 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d26,
        max(
        CASE 
            WHEN 
            dm.dia = 27 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d27,
        max(
        CASE 
            WHEN 
            dm.dia = 28 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d28,
        max(
        CASE 
            WHEN 
            dm.dia = 29 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d29,
        max(
        CASE 
            WHEN 
            dm.dia = 30 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d30,
        max(
        CASE 
            WHEN 
            dm.dia = 31 
            THEN (
                CASE
                    WHEN
                      (
                      select COUNT(horarios.turno_horario_id) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )=2            
                    THEN
                    'MT'
                    ELSE(
                      select max(tipo_turnos.abreviatura) from horarios 
                      join horario_personals on horarios.horario_personal_id=horario_personals.id
                      join turno_horario on horarios.turno_horario_id=turno_horario.id
                      join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
                      where horario_personals.personal_id =p.id 
                      AND year(horarios.fecha) = ".$ano."
                      AND month(horarios.fecha) = ".$mes."
                      AND day(horarios.fecha) = dm.dia
                      )
                END
                  )
            END
        ) as d31
    FROM
        personales p
    JOIN
        dias_mes dm ON 1=1
    WHERE  
        p.tipo_trabajador_id = ".$tipo_trabajador_id." AND p.profesion_id = ".$profesion_id." AND p.establecimiento_id = ".$establecimiento_id."
    GROUP BY
        p.id, p.numero_dni, p.apellido_paterno, p.apellido_materno, p.nombres

    ORDER BY
        p.apellido_paterno ASC, p.apellido_materno ASC, p.nombres ASC;

    ");
    //['anio' => $ano, 'mes' => $mes, 'tipo_trabajador_id' => $tipo_trabajador_id, 'profesion_id' => $profesion_id, 'establecimiento_id', $establecimiento_id]





//     return DB::select("
//     select p.id,p.numero_dni,  concat(p.apellido_paterno,' ',p.apellido_materno,' ',p.nombres) as apellidos_nombres, p.tipo_trabajador_id as tipo_trabajador_id,
//     p.profesion_id as profesion_id, p.establecimiento_id as establecimiento_id, 
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 1 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d1,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 2 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d2,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 3 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d3,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 4 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d4,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 5 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d5,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 6 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d6,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 7 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d7,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 8 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d8,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 9 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d9,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 10 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d10,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = :mes 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d11,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 12 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d12,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 13 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d13,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 14 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d14,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 15 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d15,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 16 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d16,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 17 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d17,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 18 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d18,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 19 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d19,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 20 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d20,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 21 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d21,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 22 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d22,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 23 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d23,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 24 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d24,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 25 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d25,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 26 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d26,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 27 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d27,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 28 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d28,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 29 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d29,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 30 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d30,
//     max(
//     CASE 
//         WHEN 
//         dm.dia = 31 
//         THEN (
//             CASE
//                 WHEN
//                   (
//                   select COUNT(horarios.turno_horario_id) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )=2            
//                 THEN
//                 'MT'
//                 ELSE(
//                   select max(tipo_turnos.abreviatura) from horarios 
//                   join horario_personals on horarios.horario_personal_id=horario_personals.id
//                   join turno_horario on horarios.turno_horario_id=turno_horario.id
//                   join tipo_turnos on turno_horario.tipo_turno_id=tipo_turnos.id
//                   where horario_personals.personal_id =p.id 
//                   AND year(horarios.fecha) = :anio
//                   AND month(horarios.fecha) = :mes
//                   AND day(horarios.fecha) = dm.dia
//                   )
//             END
//               )
//         END
//     ) as d31
// FROM
//     personales p
// JOIN
//     dias_mes dm ON 1=1
// GROUP BY
//     p.id, p.numero_dni, p.apellido_paterno, p.apellido_materno, p.nombres
// WHERE  
//     p.tipo_trabajador_id = :tipo_trabajador_id AND
//     p.profesion_id = :profesion_id AND
//     p.establecimiento_id = :establecimiento_id
// ORDER BY
//     p.apellido_paterno ASC, p.apellido_materno ASC, p.nombres ASC;

// ", ['anio' => 2023, 'mes' => 11, 'tipo_trabajador_id' => 1, 'profesion_id' => 15, 'establecimiento_id', 1]);
// //['anio' => $ano, 'mes' => $mes, 'tipo_trabajador_id' => $tipo_trabajador_id, 'profesion_id' => $profesion_id, 'establecimiento_id', $establecimiento_id]





    }




}
