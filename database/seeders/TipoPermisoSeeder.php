<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoPermiso;
class TipoPermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipopermiso = TipoPermiso::firstOrCreate(['abreviatura' => 'PFMD', 'nombre' => 'POR FALLECIMIENTO DE FAMILIAR DIRECTO']);
        $tipopermiso = TipoPermiso::firstOrCreate(['abreviatura' => 'PPHP', 'nombre' => 'POR HORAS (PARTICULAR)']);
        $tipopermiso = TipoPermiso::firstOrCreate(['abreviatura' => 'O', 'abreviatura' => 'O', 'nombre' => 'ONOMASTICO']);
        $tipopermiso = TipoPermiso::firstOrCreate(['abreviatura' => 'GM', 'nombre' => 'GESTION MUNICIPAL']);
        $tipopermiso = TipoPermiso::firstOrCreate(['abreviatura' => 'ADM', 'nombre' => 'ADMINISTRATIVO']);
        $tipopermiso = TipoPermiso::firstOrCreate(['abreviatura' => 'PPHES', 'nombre' => 'POR HORAS (ESSALUD)']);
        $tipopermiso = TipoPermiso::firstOrCreate(['abreviatura' => 'PPHO', 'nombre' => 'POR HORAS (MOTIVOS,OFICIAL)']);
        $tipopermiso = TipoPermiso::firstOrCreate(['abreviatura' => 'LPE', 'nombre' => 'POR ENFERMEDAD']);
        $tipopermiso = TipoPermiso::firstOrCreate(['abreviatura' => 'DPG', 'nombre' => 'DESCANSO POST GUARDIA']);
        $tipopermiso = TipoPermiso::firstOrCreate(['abreviatura' => 'PPD', 'nombre' => 'POR HORAS EXTRAS (POR DIA)']);
        $tipopermiso = TipoPermiso::firstOrCreate(['abreviatura' => 'PPHEX', 'nombre' => 'POR HORAS EXTRAS']);
        $tipopermiso = TipoPermiso::firstOrCreate(['abreviatura' => 'PCCS', 'nombre' => 'CONSTANCIA DE COMISION DE SERVICIO']);
        $tipopermiso = TipoPermiso::firstOrCreate(['abreviatura' => 'PSGH', 'nombre' => 'SIN GOCE DE HABER']);
        $tipopermiso = TipoPermiso::firstOrCreate(['abreviatura' => 'SPMD', 'nombre' => 'SANCION POR MEDIDA DISCIPLINARIA']);
        $tipopermiso = TipoPermiso::firstOrCreate(['abreviatura' => 'ADS', 'nombre' => 'ABANDONO DE SERVICIO']);
        $tipopermiso = TipoPermiso::firstOrCreate(['abreviatura' => 'VAC', 'nombre' => 'VACACIONES']);
        $tipopermiso = TipoPermiso::firstOrCreate(['abreviatura' => 'OTR', 'nombre' => 'OTROS']);
    }
}
