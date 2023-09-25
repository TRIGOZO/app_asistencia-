<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $permiso = Personal::firstOrCreate([
        //     'numero_dni' => '40422582',
        //     'nombres' => 'CARLOS PAVEL',
        //     'apellido_paterno' => 'GARAY',
        //     'apellido_materno' => 'MANZANO',
        //     'fecha_nacimiento'   => '1974-01-20',
        //     'estado_civil_id'  => EstadoCivil::where('nombre', 'SOLTERO')->value('id'),
        //     'email'         => 'email@me.com',
        //     'sueldo'        =>  '4224',
        //     'fecha_inicio'  => '1900-10-10',
        //     'fecha_fin'  => '1900-10-10',
        //     'nivel_id'  => '61',
        //    'tipo_trabajador_id'  => '1',
        //     'condicion_laboral_id'  => CondicionLaboral::where('nombre', 'NOMBRADO')->value('id'),
        //     'cargo_id'  => Cargo::where('nombre', 'CIRUJANO DENTISTA I')->value('id'),
        //     'profesion_id' => Profesion::where('nombre', 'REGULARIZAR')->value('id'),
        //     'establecimiento_id' => Establecimiento::where('codigo', '100111201')->value('id'),
        // ]);
    }
}
