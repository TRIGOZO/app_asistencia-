<?php

namespace Database\Seeders;

use App\Models\HorarioTurno;
use App\Models\TipoTurno;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HorarioTurnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $registros = [
        [
            'tipo_turno_id' => TipoTurno::where('nombre','MAÑANA')->value('id'),
            'horaentrada'   => '08:00',
            'horasalida'   => '13:00',
            'toleranciaantes'   => 0,
            'toleranciadespues' => 10,
            'inicioentrada'     => '07:30',
            'finentrada'        => '08:30',
            'iniciosalida'      => '13:00',
            'finsalida'         => '13:30',            
            'dialunes'          => 1,
            'diamartes'         => 1,
            'diamiercoles'      => 1,
            'diajueves'         => 1,
            'diaviernes'        => 1,
            'diasabado'         => 0,
            'diadomingo'        => 0,
            'totalhoras'        => '05:00:00',
        ],
        [
            'tipo_turno_id' => TipoTurno::where('nombre','TARDE')->value('id'),
            'horaentrada' => '14:30:00',
            'horasalida' => '17:30:00',
            'toleranciaantes' => 10,
            'toleranciadespues' => 0,
            'inicioentrada' => '14:00:00',
            'finentrada' => '14:40:00',
            'iniciosalida' => '17:30:00',
            'finsalida' => '22:00:00',
            'dialunes' => 1,
            'diamartes' => 1,
            'diamiercoles' => 1,
            'diajueves' => 1,
            'diaviernes' => 1,
            'diasabado' => 0,
            'diadomingo' => 0,
            'totalhoras' => '15:00:00',
        ],
        [
            'tipo_turno_id' => 9,
            'horaentrada' => '08:00:00',
            'horasalida' => '13:00:00',
            'toleranciaantes' => 0,
            'toleranciadespues' => 5,
            'inicioentrada' => '07:30:00',
            'finentrada' => '13:30:00',
            'iniciosalida' => '13:00:00',
            'finsalida' => '13:45:00',
            'dialunes' => 1,
            'diamartes' => 1,
            'diamiercoles' => 1,
            'diajueves' => 1,
            'diaviernes' => 1,
            'diasabado' => 0,
            'diadomingo' => 0,
            'totalhoras' => '05:00:00',
        ],
        [
            'tipo_turno_id' => TipoTurno::where('nombre','LIM ADM')->value('id'),
            'horaentrada' => '05:00:00',
            'horasalida' => '13:00:00',
            'toleranciaantes' => 60,
            'toleranciadespues' => 5,
            'inicioentrada' => '04:00:00',
            'finentrada' => '05:30:00',
            'iniciosalida' => '13:00:00',
            'finsalida' => '14:00:00',
            'dialunes' => 1,
            'diamartes' => 1,
            'diamiercoles' => 1,
            'diajueves' => 1,
            'diaviernes' => 1,
            'diasabado' => 0,
            'diadomingo' => 0,
            'totalhoras' => '08:00:00',
        ],
        [
            'tipo_turno_id' => TipoTurno::where('nombre','VIG ADM')->value('id'),
            'horaentrada' => '07:30:00',
            'horasalida' => '07:30:00',
            'toleranciaantes' => 0,
            'toleranciadespues' => 0,
            'inicioentrada' => '07:00:00',
            'finentrada' => '08:00:00',
            'iniciosalida' => '07:30:00',
            'finsalida' => '07:30:00',
            'dialunes' => 1,
            'diamartes' => 1,
            'diamiercoles' => 1,
            'diajueves' => 1,
            'diaviernes' => 1,
            'diasabado' => 1,
            'diadomingo' => 1,
            'totalhoras' => '00:00:00',
        ],
    ];
    foreach($registros as $fila){
        HorarioTurno::firstOrCreate($fila);
    }



    }
}
