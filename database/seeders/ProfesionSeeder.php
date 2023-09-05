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
            'AUXILIAR DE LIMPIEZA',
            'REGULARIZAR',
            'TRABAJADOR DE SERVICIO',
            'TECNICO EN LABORATORIO',
            'TECNICO EN ENFERMERIA',
            'ENFERMERA(O)',
            'ASISTENTE ADMINISTRATIVO',
          'TECNICO EN FARMACIA',
           'PSICOLOGO(A)',
          'VIGILANTE',
          'TECNICO DE FARMACIA',
          'TECNICO EN ESTADISTICA',
          'OBSTETRA',
          'TECNICO EN SEGURIDAD',
           'MEDICO CIRUJANO',
           'TECNICO/A ADMINISTRATIVO/A',
           'PILOTO DE AMBULANCIA',
           'ODONTOLOGO (A)',
            'MEDICO ESP. GINECOLOGIA Y OBST',
            'MEDICO CARDIOLOGO',
           'SECRETARIA',
            'ESPECIALISTA ADMINISTRATIVO',
            'TECNICO EN SALUD AMBIENTAL',
            'TECNICO EN INFORMATICA',
            'MEDICO',
            'TRABAJADORA SOCIAL',
            'MEDICO VETERINARIO',
           'INGENIERO DE SISTEMAS',
           'QUIMICO FARMACEUTICO',
           'AUXILIAR ADMINISTRATIVO',
           'CHOFER',
           'AUXILIAR EN DIGITACION',
           'DIRECTOR EJECUTIVO',
           'CONSERJE',
          'TERAPISTA',
           'TECNICO EN MANTENIMIENTO EQUIP',
           'MEDICO PSIQUIATRA',
           'CIRUJANO DENTISTA',
           'ABOGADO(A)',
            'MEDICO PEDIATRA',
            


        ];

        foreach ($profesiones as $nombreProfesion) {
            Profesion::firstOrCreate(['nombre' => $nombreProfesion]);
        }
    }
}
