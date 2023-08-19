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
                'nroturnos' => 1
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
                'abreviatura' => 'V',
                'nombre' => 'VACACIONES',
                'diastolerancia' => 30,
                'descuento' => 0,
                'guardia' => 0,
                'permiso' => 1,
                'horasantesdescansa' => 0,
                'horasdespuesdescansa' => 0,
                'horaasistencial' => 1,
                'horaadministrativo' => 1,
                'nroturnos' => 0
            ],
            [
                'abreviatura' => 'LPE',
                'nombre' => 'PERMISO - POR ENFERMEDAD',
                'diastolerancia' => 100,
                'descuento' => 0,
                'guardia' => 0,
                'permiso' => 1,
                'horasantesdescansa' => 0,
                'horasdespuesdescansa' => 0,
                'horaasistencial' => 1,
                'horaadministrativo' => 1,
                'nroturnos' => 0
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
        ];
        foreach ($tipoturnos as $menuData) {
            $menu = TipoTurno::firstOrCreate($menuData);
        }
    }
}
