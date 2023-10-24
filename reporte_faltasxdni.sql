select horarios.nombredia, horarios.turno_horario_id, horarios.fecha, 
(
	select count(fecha_hora) from marcaciones 
    where 
		date(marcaciones.fecha_hora)=horarios.fecha and 
		marcaciones.personal_id=horario_personals.personal_id AND 
        (
			(
				TIME(marcaciones.fecha_hora)>= turno_horario.inicioentrada 
				AND TIME(marcaciones.fecha_hora) <= turno_horario.finentrada
			)
			OR (
				TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
				AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida        
			)
		)
) as marcaciones,
horarios.hora_entrada, horarios.hora_salida
from horarios 
inner join horario_personals on horarios.horario_personal_id=horario_personals.id
inner join turno_horario on horarios.turno_horario_id=turno_horario.id
where horarios.horario_personal_id=1;



----------------------------------
select horarios.fecha, 
count(marcaciones.id) as marcaciones
from horarios 
inner join horario_personals on horarios.horario_personal_id=horario_personals.id
inner join turno_horario on horarios.turno_horario_id=turno_horario.id
left join marcaciones on 
	(
			date(marcaciones.fecha_hora)=horarios.fecha and 
			marcaciones.personal_id=horario_personals.personal_id AND 
			(
				(
					TIME(marcaciones.fecha_hora)>= turno_horario.inicioentrada 
					AND TIME(marcaciones.fecha_hora) <= turno_horario.finentrada
				)
				OR (
					TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
					AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida        
				)
			)
	)
where horarios.horario_personal_id=1
group by horarios.fecha;
---------------------------------------------------------
select horarios.fecha, 
count(marcaciones.id) as marcaciones
from horarios 
inner join horario_personals on horarios.horario_personal_id=horario_personals.id
inner join turno_horario on horarios.turno_horario_id=turno_horario.id
left join marcaciones on 
	(
			date(marcaciones.fecha_hora)=horarios.fecha and 
			marcaciones.personal_id=horario_personals.personal_id AND 
			(
				(
					TIME(marcaciones.fecha_hora)>= turno_horario.inicioentrada 
					AND TIME(marcaciones.fecha_hora) <= turno_horario.finentrada
				)
				OR (
					TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
					AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida        
				)
			)
	)
where horario_personals.personal_id=1 and
month(horarios.fecha)=9 and
year (horarios.fecha)=2023
group by horarios.fecha;
------------------------------------------------------------------
select horarios.fecha,
sum(
	case 
		when (
			select count(marcaciones.fecha_hora) from marcaciones
			where date(marcaciones.fecha_hora)=horarios.fecha and marcaciones.personal_id=horario_personals.personal_id AND
				(
					(
						TIME(marcaciones.fecha_hora)>= turno_horario.inicioentrada 
						AND TIME(marcaciones.fecha_hora) <= turno_horario.finentrada
					)
					OR (
						TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
						AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida        
					)
				)
		
		) >= 2
		then
		1
	end 
) as marcaciones
from horarios 
inner join horario_personals on horarios.horario_personal_id=horario_personals.id
inner join turno_horario on horarios.turno_horario_id=turno_horario.id
where horario_personals.personal_id=1 and
month(horarios.fecha)=9 and
year (horarios.fecha)=2023
group by horarios.fecha;
---------------------------------------------------
select horarios.fecha,
sum(
	(
		select count(marcaciones.fecha_hora) from marcaciones
		where date(marcaciones.fecha_hora)=horarios.fecha and marcaciones.personal_id=horario_personals.personal_id AND
			(
				(
					TIME(marcaciones.fecha_hora)>= turno_horario.inicioentrada 
					AND TIME(marcaciones.fecha_hora) <= turno_horario.finentrada
				)
				OR (
					TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
					AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida        
				)
			)
		
	)
) as marcaciones
from horarios 
inner join horario_personals on horarios.horario_personal_id=horario_personals.id
inner join turno_horario on horarios.turno_horario_id=turno_horario.id
where horario_personals.personal_id=1 and
month(horarios.fecha)=9 and
year (horarios.fecha)=2023
group by horarios.fecha;
--------------------------------------------------------------
select horarios.fecha,
sum(
case
	when
	(
		select count(marcaciones.fecha_hora) from marcaciones
		where date(marcaciones.fecha_hora)=horarios.fecha and marcaciones.personal_id=horario_personals.personal_id AND
			(
				(
					TIME(marcaciones.fecha_hora)>= turno_horario.inicioentrada 
					AND TIME(marcaciones.fecha_hora) <= turno_horario.finentrada
				)
				OR (
					TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
					AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida        
				)
			)
		
	)>=2
    then
    1
    when 
		(
			select count(marcaciones.fecha_hora) from marcaciones
			where date(marcaciones.fecha_hora)=horarios.fecha and marcaciones.personal_id=horario_personals.personal_id AND
			(
				(
					TIME(marcaciones.fecha_hora)>= turno_horario.inicioentrada 
					AND TIME(marcaciones.fecha_hora) <= turno_horario.finentrada
				)
			)
		)=0
	then
	(
		case
        when
			(select count(permisos.id) from permisos where personal_id=horario_personals.personal_id and 
				(
					CAST(CONCAT(horarios.fecha, ' ', horarios.hora_entrada) AS DATETIME) >= 
					CAST(CONCAT(permisos.fecha_desde, ' ', permisos.hora_inicio) AS DATETIME)
				)
				AND
				(
					CAST(CONCAT(horarios.fecha, ' ', horarios.hora_entrada) AS DATETIME) <= 
					CAST(CONCAT(permisos.fecha_hasta, ' ', permisos.hora_hasta) AS DATETIME)
				)
			)=0
        then
        0
        when
			(
				select count(marcaciones.fecha_hora) from marcaciones
				where date(marcaciones.fecha_hora)=horarios.fecha and marcaciones.personal_id=horario_personals.personal_id AND
				(
					(
						TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
						AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida
					)
				)
			)=0
        then
			(
				case 
                when
					(select count(permisos.id) from permisos where personal_id=horario_personals.personal_id and 
							(
								CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) >= 
								CAST(CONCAT(permisos.fecha_desde, ' ', permisos.hora_inicio) AS DATETIME)
							)
							AND
							(
								CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) <= 
								CAST(CONCAT(permisos.fecha_hasta, ' ', permisos.hora_hasta) AS DATETIME)
							)
					)=0
                then
                0
                else
                1
                end
            )
		else
        1
        end
    )
    else
    (
		case
        when
			(
				select count(marcaciones.fecha_hora) from marcaciones
				where date(marcaciones.fecha_hora)=horarios.fecha and marcaciones.personal_id=horario_personals.personal_id AND
				(
					(
						TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
						AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida
					)
				)
			)=0
        then
			(
				case 
                when
					(select count(permisos.id) from permisos where personal_id=horario_personals.personal_id and 
							(
								CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) >= 
								CAST(CONCAT(permisos.fecha_desde, ' ', permisos.hora_inicio) AS DATETIME)
							)
							AND
							(
								CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) <= 
								CAST(CONCAT(permisos.fecha_hasta, ' ', permisos.hora_hasta) AS DATETIME)
							)
					)=0
                then
                0
                else
                1
                end
            )
        end
    )
end
) as marcaciones
from horarios 
inner join horario_personals on horarios.horario_personal_id=horario_personals.id
inner join turno_horario on horarios.turno_horario_id=turno_horario.id
where horario_personals.personal_id=1 and
month(horarios.fecha)=9 and
year (horarios.fecha)=2023
group by horarios.fecha;
----------------------------------------------------------------------------
select horarios.fecha,
sum(
case
	when
	(
		select count(marcaciones.fecha_hora) from marcaciones
		where date(marcaciones.fecha_hora)=horarios.fecha and marcaciones.personal_id=horario_personals.personal_id AND
			(
				(
					TIME(marcaciones.fecha_hora)>= turno_horario.inicioentrada 
					AND TIME(marcaciones.fecha_hora) <= turno_horario.finentrada
				)
				OR (
					TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
					AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida        
				)
			)
		
	)>=2
    then
    1
    when 
		(
			select count(marcaciones.fecha_hora) from marcaciones
			where date(marcaciones.fecha_hora)=horarios.fecha and marcaciones.personal_id=horario_personals.personal_id AND
			(
				(
					TIME(marcaciones.fecha_hora)>= turno_horario.inicioentrada 
					AND TIME(marcaciones.fecha_hora) <= turno_horario.finentrada
				)
			)
		)=0
	then
	(
		case
        when
			(select count(permisos.id) from permisos where personal_id=horario_personals.personal_id and 
				(
					CAST(CONCAT(horarios.fecha, ' ', horarios.hora_entrada) AS DATETIME) >= 
					CAST(CONCAT(permisos.fecha_desde, ' ', permisos.hora_inicio) AS DATETIME)
				)
				AND
				(
					CAST(CONCAT(horarios.fecha, ' ', horarios.hora_entrada) AS DATETIME) <= 
					CAST(CONCAT(permisos.fecha_hasta, ' ', permisos.hora_hasta) AS DATETIME)
				)
			)=0
        then
        0
        when
			(
				select count(marcaciones.fecha_hora) from marcaciones
				where date(marcaciones.fecha_hora)=horarios.fecha and marcaciones.personal_id=horario_personals.personal_id AND
				(
					(
						TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
						AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida
					)
				)
			)=0
        then
			(
				case 
                when
					(select count(permisos.id) from permisos where personal_id=horario_personals.personal_id and 
							(
								CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) >= 
								CAST(CONCAT(permisos.fecha_desde, ' ', permisos.hora_inicio) AS DATETIME)
							)
							AND
							(
								CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) <= 
								CAST(CONCAT(permisos.fecha_hasta, ' ', permisos.hora_hasta) AS DATETIME)
							)
					)=0
                then
                0
                else
                1
                end
            )
		else
        1
        end
    )
    else
    (
		case
        when
			(
				select count(marcaciones.fecha_hora) from marcaciones
				where date(marcaciones.fecha_hora)=horarios.fecha and marcaciones.personal_id=horario_personals.personal_id AND
				(
					(
						TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
						AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida
					)
				)
			)=0
        then
			(
				case 
                when
					(select count(permisos.id) from permisos where personal_id=horario_personals.personal_id and 
							(
								CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) >= 
								CAST(CONCAT(permisos.fecha_desde, ' ', permisos.hora_inicio) AS DATETIME)
							)
							AND
							(
								CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) <= 
								CAST(CONCAT(permisos.fecha_hasta, ' ', permisos.hora_hasta) AS DATETIME)
							)
					)=0
                then
                0
                else
                1
                end
            )
        end
    )
end
) as marcaciones
from horarios 
inner join horario_personals on horarios.horario_personal_id=horario_personals.id
inner join turno_horario on horarios.turno_horario_id=turno_horario.id
where horario_personals.personal_id=1 and
month(horarios.fecha)=9 and
year (horarios.fecha)=2023
group by horarios.fecha;

--------------------------------------------------------------------------------
select personales.id, concat(personales.apellido_paterno, ' ',personales.apellido_materno, ', ', personales.nombres) as apenom,
personales.numero_dni, horarios.fecha, 
sum(
case
	when
	(
		select count(marcaciones.fecha_hora) from marcaciones
		where date(marcaciones.fecha_hora)=horarios.fecha and marcaciones.personal_id=horario_personals.personal_id AND
			(
				(
					TIME(marcaciones.fecha_hora)>= turno_horario.inicioentrada 
					AND TIME(marcaciones.fecha_hora) <= turno_horario.finentrada
				)
				OR (
					TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
					AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida        
				)
			)
		
	)>=2
    then
    1
    when 
		(
			select count(marcaciones.fecha_hora) from marcaciones
			where date(marcaciones.fecha_hora)=horarios.fecha and marcaciones.personal_id=horario_personals.personal_id AND
			(
				(
					TIME(marcaciones.fecha_hora)>= turno_horario.inicioentrada 
					AND TIME(marcaciones.fecha_hora) <= turno_horario.finentrada
				)
			)
		)=0
	then
	(
		case
        when
			(select count(permisos.id) from permisos where personal_id=horario_personals.personal_id and 
				(
					CAST(CONCAT(horarios.fecha, ' ', horarios.hora_entrada) AS DATETIME) >= 
					CAST(CONCAT(permisos.fecha_desde, ' ', permisos.hora_inicio) AS DATETIME)
				)
				AND
				(
					CAST(CONCAT(horarios.fecha, ' ', horarios.hora_entrada) AS DATETIME) <= 
					CAST(CONCAT(permisos.fecha_hasta, ' ', permisos.hora_hasta) AS DATETIME)
				)
			)=0
        then
        0
        when
			(
				select count(marcaciones.fecha_hora) from marcaciones
				where date(marcaciones.fecha_hora)=horarios.fecha and marcaciones.personal_id=horario_personals.personal_id AND
				(
					(
						TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
						AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida
					)
				)
			)=0
        then
			(
				case 
                when
					(select count(permisos.id) from permisos where personal_id=horario_personals.personal_id and 
							(
								CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) >= 
								CAST(CONCAT(permisos.fecha_desde, ' ', permisos.hora_inicio) AS DATETIME)
							)
							AND
							(
								CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) <= 
								CAST(CONCAT(permisos.fecha_hasta, ' ', permisos.hora_hasta) AS DATETIME)
							)
					)=0
                then
                0
                else
                1
                end
            )
		else
        1
        end
    )
    else
    (
		case
        when
			(
				select count(marcaciones.fecha_hora) from marcaciones
				where date(marcaciones.fecha_hora)=horarios.fecha and marcaciones.personal_id=horario_personals.personal_id AND
				(
					(
						TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
						AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida
					)
				)
			)=0
        then
			(
				case 
                when
					(select count(permisos.id) from permisos where personal_id=horario_personals.personal_id and 
							(
								CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) >= 
								CAST(CONCAT(permisos.fecha_desde, ' ', permisos.hora_inicio) AS DATETIME)
							)
							AND
							(
								CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) <= 
								CAST(CONCAT(permisos.fecha_hasta, ' ', permisos.hora_hasta) AS DATETIME)
							)
					)=0
                then
                0
                else
                1
                end
            )
        end
    )
end
) as marcaciones
from horarios 
inner join horario_personals on horarios.horario_personal_id=horario_personals.id
inner join turno_horario on horarios.turno_horario_id=turno_horario.id
inner join personales on horario_personals.personal_id=personales.id
where horario_personals.personal_id=1 and
month(horarios.fecha)=9 and
year (horarios.fecha)=2023
group by horarios.fecha;
---------------------------------------------------------------------------------
select personales.id, personales.numero_dni, horarios.fecha, concat(personales.apellido_paterno, ' ',personales.apellido_materno, ', ', personales.nombres) as apenom,
sum(
case
	when
	(
		select count(marcaciones.fecha_hora) from marcaciones
		where date(marcaciones.fecha_hora)=horarios.fecha and marcaciones.personal_id=horario_personals.personal_id AND
			(
				(
					TIME(marcaciones.fecha_hora)>= turno_horario.inicioentrada 
					AND TIME(marcaciones.fecha_hora) <= turno_horario.finentrada
				)
				OR (
					TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
					AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida        
				)
			)
		
	)>=2
    then
    1
    when 
		(
			select count(marcaciones.fecha_hora) from marcaciones
			where date(marcaciones.fecha_hora)=horarios.fecha and marcaciones.personal_id=horario_personals.personal_id AND
			(
				(
					TIME(marcaciones.fecha_hora)>= turno_horario.inicioentrada 
					AND TIME(marcaciones.fecha_hora) <= turno_horario.finentrada
				)
			)
		)=0
	then
	(
		case
        when
			(select count(permisos.id) from permisos where personal_id=horario_personals.personal_id and 
				(
					CAST(CONCAT(horarios.fecha, ' ', horarios.hora_entrada) AS DATETIME) >= 
					CAST(CONCAT(permisos.fecha_desde, ' ', permisos.hora_inicio) AS DATETIME)
				)
				AND
				(
					CAST(CONCAT(horarios.fecha, ' ', horarios.hora_entrada) AS DATETIME) <= 
					CAST(CONCAT(permisos.fecha_hasta, ' ', permisos.hora_hasta) AS DATETIME)
				)
			)=0
        then
        0
        when
			(
				select count(marcaciones.fecha_hora) from marcaciones
				where date(marcaciones.fecha_hora)=horarios.fecha and marcaciones.personal_id=horario_personals.personal_id AND
				(
					(
						TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
						AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida
					)
				)
			)=0
        then
			(
				case 
                when
					(select count(permisos.id) from permisos where personal_id=horario_personals.personal_id and 
							(
								CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) >= 
								CAST(CONCAT(permisos.fecha_desde, ' ', permisos.hora_inicio) AS DATETIME)
							)
							AND
							(
								CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) <= 
								CAST(CONCAT(permisos.fecha_hasta, ' ', permisos.hora_hasta) AS DATETIME)
							)
					)=0
                then
                0
                else
                1
                end
            )
		else
        1
        end
    )
    else
    (
		case
        when
			(
				select count(marcaciones.fecha_hora) from marcaciones
				where date(marcaciones.fecha_hora)=horarios.fecha and marcaciones.personal_id=horario_personals.personal_id AND
				(
					(
						TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
						AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida
					)
				)
			)=0
        then
			(
				case 
                when
					(select count(permisos.id) from permisos where personal_id=horario_personals.personal_id and 
							(
								CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) >= 
								CAST(CONCAT(permisos.fecha_desde, ' ', permisos.hora_inicio) AS DATETIME)
							)
							AND
							(
								CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) <= 
								CAST(CONCAT(permisos.fecha_hasta, ' ', permisos.hora_hasta) AS DATETIME)
							)
					)=0
                then
                0
                else
                1
                end
            )
        end
    )
end
) as marcaciones
from horarios 
inner join horario_personals on horarios.horario_personal_id=horario_personals.id
inner join turno_horario on horarios.turno_horario_id=turno_horario.id
inner join personales on horario_personals.personal_id=personales.id
group by personales.id, horarios.fecha;
--------------------------------------------------------------------------------
DROP view IF EXISTS vistamarcaciones; 
create view vistamarcaciones as 
select personales.id as personal_id, personales.numero_dni, horarios.fecha as fecha, 
concat(personales.apellido_paterno, ' ',personales.apellido_materno, ', ', personales.nombres) as apenom,
sum(
case
	when
	(
		select count(marcaciones.fecha_hora) from marcaciones
		where date(marcaciones.fecha_hora)=horarios.fecha and marcaciones.personal_id=horario_personals.personal_id AND
			(
				(
					TIME(marcaciones.fecha_hora)>= turno_horario.inicioentrada 
					AND TIME(marcaciones.fecha_hora) <= turno_horario.finentrada
				)
				OR (
					TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
					AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida        
				)
			)
		
	)>=2
    then
    1
    when 
		(
			select count(marcaciones.fecha_hora) from marcaciones
			where date(marcaciones.fecha_hora)=horarios.fecha and marcaciones.personal_id=horario_personals.personal_id AND
			(
				(
					TIME(marcaciones.fecha_hora)>= turno_horario.inicioentrada 
					AND TIME(marcaciones.fecha_hora) <= turno_horario.finentrada
				)
			)
		)=0
	then
	(
		case
        when
			(select count(permisos.id) from permisos where personal_id=horario_personals.personal_id and 
				(
					CAST(CONCAT(horarios.fecha, ' ', horarios.hora_entrada) AS DATETIME) >= 
					CAST(CONCAT(permisos.fecha_desde, ' ', permisos.hora_inicio) AS DATETIME)
				)
				AND
				(
					CAST(CONCAT(horarios.fecha, ' ', horarios.hora_entrada) AS DATETIME) <= 
					CAST(CONCAT(permisos.fecha_hasta, ' ', permisos.hora_hasta) AS DATETIME)
				)
			)=0
        then
        0
        when
			(
				select count(marcaciones.fecha_hora) from marcaciones
				where date(marcaciones.fecha_hora)=horarios.fecha and marcaciones.personal_id=horario_personals.personal_id AND
				(
					(
						TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
						AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida
					)
				)
			)=0
        then
			(
				case 
                when
					(select count(permisos.id) from permisos where personal_id=horario_personals.personal_id and 
							(
								CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) >= 
								CAST(CONCAT(permisos.fecha_desde, ' ', permisos.hora_inicio) AS DATETIME)
							)
							AND
							(
								CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) <= 
								CAST(CONCAT(permisos.fecha_hasta, ' ', permisos.hora_hasta) AS DATETIME)
							)
					)=0
                then
                0
                else
                1
                end
            )
		else
        1
        end
    )
    else
    (
		case
        when
			(
				select count(marcaciones.fecha_hora) from marcaciones
				where date(marcaciones.fecha_hora)=horarios.fecha and marcaciones.personal_id=horario_personals.personal_id AND
				(
					(
						TIME(marcaciones.fecha_hora)>= turno_horario.iniciosalida 
						AND TIME(marcaciones.fecha_hora) <= turno_horario.finsalida
					)
				)
			)=0
        then
			(
				case 
                when
					(select count(permisos.id) from permisos where personal_id=horario_personals.personal_id and 
							(
								CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) >= 
								CAST(CONCAT(permisos.fecha_desde, ' ', permisos.hora_inicio) AS DATETIME)
							)
							AND
							(
								CAST(CONCAT(horarios.fecha, ' ', horarios.hora_salida) AS DATETIME) <= 
								CAST(CONCAT(permisos.fecha_hasta, ' ', permisos.hora_hasta) AS DATETIME)
							)
					)=0
                then
                0
                else
                1
                end
            )
        end
    )
end
) as marcaciones
from horarios 
inner join horario_personals on horarios.horario_personal_id=horario_personals.id
inner join turno_horario on horarios.turno_horario_id=turno_horario.id
inner join personales on horario_personals.personal_id=personales.id
group by personales.id, horarios.fecha;
--------------------------------------------------------------------------------------------------------------------------------------------
select personales.numero_dni, concat(personales.apellido_paterno, ' ',personales.apellido_materno, ', ', personales.nombres) as apenom,
condicion_laborales.nombre as condicion, cargos.nombre as cargo, personales.nivel_id as nivel,
sum(if(marcaciones<2, 1,0)) as faltas,
personales.sueldo, round(if(personales.tipo_trabajador_id=1,sueldo/25, sueldo/30),2) as sueldo_diario,
(sum(if(marcaciones<2, 1,0))*round(if(personales.tipo_trabajador_id=1,sueldo/25, sueldo/30),2)) as descuentototal
from personales
inner join vistamarcaciones on personales.id=vistamarcaciones.personal_id
inner join condicion_laborales on personales.condicion_laboral_id=condicion_laborales.id
inner join cargos on personales.cargo_id=cargos.id
where establecimiento_id=1 and
month(vistamarcaciones.fecha)=9 and
year(vistamarcaciones.fecha)=2023
group by personales.id having sum(if(marcaciones<2, 1,0))>0


