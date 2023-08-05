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
        $cargo = Cargo::firstOrCreate(['nombre'=> 'SUPER']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'TRABAJADOR']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'JEFE DE SERVICIO']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'JEFE DE RR. HH. ESTABLECIMIENTO']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'JEFE DE RR. HH. MICRORED']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'JEFE DE RR. HH. RED']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'DIRECTOR ESTABLECIMIENTO']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'DIRECTOR RED']);
    }
}
