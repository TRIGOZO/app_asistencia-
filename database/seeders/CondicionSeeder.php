<?php

namespace Database\Seeders;

use App\Models\CondicionLaboral;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CondicionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $condicion = CondicionLaboral::firstOrCreate(['nombre' => 'NOMBRADO']);
        $condicion = CondicionLaboral::firstOrCreate(['nombre' => 'CONTRATADO - CAS']);
        $condicion = CondicionLaboral::firstOrCreate(['nombre' => 'SERUMS REGIONAL']);
        $condicion = CondicionLaboral::firstOrCreate(['nombre' => 'CONTRATADO - 728']);
        $condicion = CondicionLaboral::firstOrCreate(['nombre' => 'GESTION MUNICIPAL']);
        $condicion = CondicionLaboral::firstOrCreate(['nombre' => 'SERUMS NACIONAL']);
        $condicion = CondicionLaboral::firstOrCreate(['nombre' => 'SERUMS EQUIVALENTE']);
    }
}
