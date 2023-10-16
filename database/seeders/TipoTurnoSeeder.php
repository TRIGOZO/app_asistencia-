<?php

namespace Database\Seeders;

use App\Models\TipoTurno;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoTurnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipoturnos = [
            [
                'abreviatura' => 'L',
                'nombre' => 'LIBRE',
                'diastolerancia' => 0,
                'descuento' => 0,
                'guardia' => 0,
                'permiso' => 0,
                'horasantesdescansa' => 0,
                'horasdespuesdescansa' => 0,
                'horaasistencial' => 1,
                'horaadministrativo' => 1,
                'nroturnos' => 0
            ],
            [
                'abreviatura' => 'M',
                'nombre' => 'MAÑANA',
                'diastolerancia' => 0,
                'descuento' => 1,
                'guardia' => 0,
                'permiso' => 0,
                'horasantesdescansa' => 0,
                'horasdespuesdescansa' => 0,
                'horaasistencial' => 1,
                'horaadministrativo' => 0,
                'nroturnos' => 1
            ],
            [
                'abreviatura' => 'T',
                'nombre' => 'TARDE',
                'diastolerancia' => 0,
                'descuento' => 1,
                'guardia' => 0,
                'permiso' => 0,
                'horasantesdescansa' => 0,
                'horasdespuesdescansa' => 0,
                'horaasistencial' => 1,
                'horaadministrativo' => 0,
                'nroturnos' => 1,
            ],
            [
                'abreviatura' => 'N',
                'nombre' => 'NOCHE',
                'diastolerancia' => 0,
                'descuento' => 1,
                'guardia' => 0,
                'permiso' => 0,
                'horasantesdescansa' => 0,
                'horasdespuesdescansa' => 0,
                'horaasistencial' => 1,
                'horaadministrativo' => 0,
                'nroturnos' => 2
            ],
            [
                'abreviatura' => 'MT',
                'nombre' => 'MAÑANA Y TARDE',
                'diastolerancia' => 0,
                'descuento' => 1,
                'guardia' => 0,
                'permiso' => 0,
                'horasantesdescansa' => 0,
                'horasdespuesdescansa' => 0,
                'horaasistencial' => 1,
                'horaadministrativo' => 0,
                'nroturnos' => 2
            ],
            [
                'abreviatura' => 'GN',
                'nombre' => 'GUARDIA NOCTURNA',
                'diastolerancia' => 0,
                'descuento' => 1,
                'guardia' => 1,
                'permiso' => 0,
                'horasantesdescansa' => 0,
                'horasdespuesdescansa' => 0,
                'horaasistencial' => 0,
                'horaadministrativo' => 0,
                'nroturnos' => 2
            ],
            [
                'abreviatura' => 'GD',
                'nombre' => 'GUARDIA DIURNA',
                'diastolerancia' => 0,
                'descuento' => 1,
                'guardia' => 1,
                'permiso' => 0,
                'horasantesdescansa' => 0,
                'horasdespuesdescansa' => 0,
                'horaasistencial' => 0,
                'horaadministrativo' => 0,
                'nroturnos' => 2
            ],
            [
                'abreviatura' => 'GC',
                'nombre' => 'GUARDIA COMUNITARIA',
                'diastolerancia' => 0,
                'descuento' => 1,
                'guardia' => 1,
                'permiso' => 0,
                'horasantesdescansa' => 0,
                'horasdespuesdescansa' => 0,
                'horaasistencial' => 0,
                'horaadministrativo' => 0,
                'nroturnos' => 2
            ],
            [
                'abreviatura' => 'MAÑ',
                'nombre' => 'MAÑANA ADM',
                'diastolerancia' => 0,
                'descuento' => 1,
                'guardia' => 1,
                'permiso' => 0,
                'horasantesdescansa' => 0,
                'horasdespuesdescansa' => 0,
                'horaasistencial' => 0,
                'horaadministrativo' => 5,
                'nroturnos' => 0
            ],
            [
                'abreviatura' => 'TARD',
                'nombre' => 'TARDE ADM',
                'diastolerancia' => 0,
                'descuento' => 1,
                'guardia' => 1,
                'permiso' => 0,
                'horasantesdescansa' => 0,
                'horasdespuesdescansa' => 0,
                'horaasistencial' => 0,
                'horaadministrativo' => 3,
                'nroturnos' => 0
            ],
            [
                'abreviatura' => 'VIGA',
                'nombre' => 'VIG ADM',
                'diastolerancia' => 0,
                'descuento' => 1,
                'guardia' => 1,
                'permiso' => 0,
                'horasantesdescansa' => 0,
                'horasdespuesdescansa' => 0,
                'horaasistencial' => 0,
                'horaadministrativo' => 24,
                'nroturnos' => 7
            ],
            [
                'abreviatura' => 'LIMA',
                'nombre' => 'LIM ADM',
                'diastolerancia' => 0,
                'descuento' => 1,
                'guardia' => 1,
                'permiso' => 0,
                'horasantesdescansa' => 0,
                'horasdespuesdescansa' => 0,
                'horaasistencial' => 0,
                'horaadministrativo' => 8,
                'nroturnos' => 0
            ],


        ];
        foreach ($tipoturnos as $menuData) {
            TipoTurno::firstOrCreate($menuData);
        }
    }
}
