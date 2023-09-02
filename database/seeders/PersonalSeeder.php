<?php

namespace Database\Seeders;

use App\Models\Cargo;
use App\Models\Establecimiento;
use App\Models\EstadoCivil;
use App\Models\Personal;
use App\Models\Profesion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $personal = Personal::firstOrCreate([
            'numero_dni' => '45532962',
            'nombres' => 'Cristian Wilmer',
            'apellido_paterno' => 'Figueroa',
            'apellido_materno' => 'Ferrer',
            'fecha_nacimiento'   => '1992-11-24',
            'estado_civil_id'  => EstadoCivil::where('nombre', 'SOLTERO')->value('id'),
            'email'         => 'ilandbz@gmail.com',
            'sueldo'        =>  1,
            'fecha_inicio'  => '1994-01-01',
            'fecha_fin'  => '1994-01-01',
            'cargo_id'  => Cargo::where('nombre', 'SUPER')->value('id'),
            'profesion_id' => Profesion::where('nombre', 'INFORMATICO')->value('id'),
            'establecimiento_id' => Establecimiento::where('nombre', 'C.S. CARLOS SHOWING FERRARI')->value('id'),
        ]);



    }
}
