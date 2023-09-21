<?php

namespace Database\Seeders;

use App\Models\TipoTrabajador;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoTrabajadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipotrabajador = TipoTrabajador::firstOrCreate(['nombre' => 'ASISTENCIAL']);
        $tipotrabajador = TipoTrabajador::firstOrCreate(['nombre' => 'ADMINISTRATIVO']);
    }
}