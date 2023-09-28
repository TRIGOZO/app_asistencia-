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
        $oficina = HorarioTurno::firstOrCreate([
            'tipo_turno_id' => TipoTurno::where('nombre','MAÑANA')->value('id'),
            'horaentrada'   => '08:00',
            'horasalida'   => '13:00',
            'toleranciaantes'   => 5,
            'toleranciadespues' => 5,
            'inicioentrada'     => '07:55',
            'finentrada'        => '08:05',
            'iniciosalida'      => '12:55',
            'finsalida'         => '12:55',            
            'dialunes'          => 1,
            'diamartes'         => 1,
            'diamiercoles'      => 1,
            'diajueves'         => 1,
            'diaviernes'        => 1,
            'diasabado'         => 1,
            'diadomingo'        => 0,
            'totalhoras'        => '05:00:00',
        ]);
    }
}
