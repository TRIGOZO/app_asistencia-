<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Oficina;
class OficinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $oficina = Oficina::firstOrCreate(['nombre' => 'ADMISIÓN']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'ENFERMERÍA']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'FARMACIA']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'LABORATORIO']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'LIMPIEZA']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'LOGISTICA Y PATRIMONIO']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'MEDICINA']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'OBSTETRICIA']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'ODONTOLOGIA']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'PSICOLOGÍA']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'SERVICIO SOCIAL']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'UNIDAD DE SEGUROS']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'TRANSPORTE']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'VIGILANCIA']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'RECURSOS HUMANOS']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'CAJA']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'ESTADISTICA E INFORMATICA']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'ALMACEN']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'SECRETARIA']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'PLANEAMIENTO Y PRESUPUESTO']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'ASESORIA JURIDICA']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'ECONOMIA']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'ODI']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'SANEAMIENTO AMBIENTAL']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'NUTRICION']);
        $oficina = Oficina::firstOrCreate(['nombre' => 'TECNICO EN ENFERMERIA']);
    }
}
