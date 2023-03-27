<?php

namespace Database\Seeders;
use App\Models\EstadoCivil;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoCivilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estadocivil = EstadoCivil::firstOrCreate(['nombre'=> 'SOLTERO']);
        $estadocivil = EstadoCivil::firstOrCreate(['nombre'=> 'CASADO']);
        $estadocivil = EstadoCivil::firstOrCreate(['nombre'=> 'DIVORCIADO']);
        $estadocivil = EstadoCivil::firstOrCreate(['nombre'=> 'VIUDO']);
    }
}
