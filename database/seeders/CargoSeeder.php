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
        $estadocivil = Cargo::firstOrCreate(['nombre'=> 'TRABAJADOR']);
        $estadocivil = Cargo::firstOrCreate(['nombre'=> 'JEFE DE SERVICIO']);
        $estadocivil = Cargo::firstOrCreate(['nombre'=> 'JEFE DE RR. HH. ESTABLECIMIENTO']);
        $estadocivil = Cargo::firstOrCreate(['nombre'=> 'JEFE DE RR. HH. MICRORED']);
        $estadocivil = Cargo::firstOrCreate(['nombre'=> 'JEFE DE RR. HH. RED']);
        $estadocivil = Cargo::firstOrCreate(['nombre'=> 'DIRECTOR ESTABLECIMIENTO']);
        $estadocivil = Cargo::firstOrCreate(['nombre'=> 'DIRECTOR RED']);
    }
}
