<?php

namespace Database\Seeders;

use App\Models\Profesion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfesionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profesiones = [
            'MEDICO',
            'ENFERMERO',
            'OBSTETRIZ',
            'CIRUJANO',
            'ANESTESIOLOGO',
            'RADIOLOGO',
            'LABORATORISTA',
            'FISIOTERAPEUTA',
            'PSICOLOGO',
            'NUTRICIONISTA',
            'CONTADOR',
            'INFORMATICO',
            'AUXILIAR DE SEGURIDAD',
            'AUXILIAR DE LIMPIEZA'
        ];

        foreach ($profesiones as $nombreProfesion) {
            Profesion::firstOrCreate(['nombre' => $nombreProfesion]);
        }
    }
}
