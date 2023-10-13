<?php

namespace Database\Seeders;

use App\Models\Establecimiento;
use App\Models\Marcacion;
use App\Models\Personal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarcacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $archivoLeer = storage_path('app/archivos/marcacionesprevias.txt');
        // $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        if(touch($archivoLeer)){
            $archivoId = fopen($archivoLeer, "r");
            while(!feof($archivoId)){
                $linea = fgets($archivoId, 1024);
                $dni  = substr($linea, 1, 8);
                if (strlen($dni) < 8) {
                    $dni = str_pad($dni, 8, '0', STR_PAD_LEFT);
                }
                $fecha = substr($linea, 10, 19);
                Marcacion::firstorCreate([
                    'personal_id'           => Personal::where('numero_dni', $dni)->value('id'),
                    'establecimiento_id'    => Establecimiento::where('nombre', 'SEDE RED SALUD HUANUCO')->value('id'),
                    'fecha_hora'            => $fecha,
                    'serial'                => 'AF4C172960193',
                    'ip'                    => '192.168.2.252'
                ]);

            }
            fclose($archivoId);
        }

    }
}
