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
        $cargo = Cargo::firstOrCreate(['nombre'=> 'SUPER', 'codigo' => '']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'TRABAJADOR', 'codigo' => '']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'JEFE DE SERVICIO', 'codigo' => '']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'JEFE DE RR. HH. ESTABLECIMIENTO', 'codigo' => '']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'JEFE DE RR. HH. MICRORED', 'codigo' => '']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'JEFE DE RR. HH. RED', 'codigo' => '']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'DIRECTOR ESTABLECIMIENTO', 'codigo' => '']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'DIRECTOR RED', 'codigo' => '']);
    }
}
