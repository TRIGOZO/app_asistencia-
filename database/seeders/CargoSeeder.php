<?php

namespace Database\Seeders;
use App\Models\Cargo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cargo = Cargo::firstOrCreate(['nombre'=> 'SUPER', 'codigo' => '', 'nivel' => '']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'TRABAJADOR', 'codigo' => '','nivel' => '']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'JEFE DE SERVICIO', 'codigo' => '','nivel' => '']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'JEFE DE RR. HH. ESTABLECIMIENTO', 'codigo' => '','nivel' => '']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'JEFE DE RR. HH. MICRORED', 'codigo' => '','nivel' => '']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'JEFE DE RR. HH. RED', 'codigo' => '','nivel' => '']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'DIRECTOR ESTABLECIMIENTO', 'codigo' => '','nivel' => '']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'DIRECTOR RED', 'codigo' => '','nivel' => '']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'POR DEFINIR ', 'codigo' => '','nivel' => '']);
    }
}
