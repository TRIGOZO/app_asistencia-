<?php

namespace Database\Seeders;

use App\Models\Permiso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(storage_path('app/archivos/permisos.csv'),'r');
        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 555, ',')) !== false)
        {
            $nro_registros +=1;
        }
        fclose($csvFile);
        $this->command->getOutput()->writeln('Iniciando Importación de Permisos...');
        $this->command->getOutput()->writeln('Cantidad de registros: '.$nro_registros);
        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);

        $csvFile2 = fopen(storage_path('app/archivos/permisos.csv'),"r");

        $progressBar->start();
        $firstLine = true;
        while(($fila  = fgetcsv($csvFile2,2000,";")) !== false) {
            if(!$firstLine)
            {
                $registro = explode(",",(string)$fila[0]);

                $personal_id =$registro[1];
                $fecha_desde = $registro[2];
                $hora_inicio=$registro[3];
                $fecha_hasta = $registro[4];
                $hora_hasta=$registro[5];
                $tipo_permiso_id=$registro[6];
                $motivo=str_replace('"', '', $registro[7]);
                $establecimiento_id=$registro[8];
                $estado=$registro[9];
                Permiso::firstOrCreate([
                    'personal_id'       => $personal_id,
                    'fecha_desde'       => $fecha_desde,
                    'hora_inicio'       => $hora_inicio,
                    'fecha_hasta'       => $fecha_hasta,
                    'hora_hasta'        => $hora_hasta,
                    'tipo_permiso_id'   => $tipo_permiso_id,
                    'motivo'            => $motivo,
                    'establecimiento_id'=>  $establecimiento_id,
                    'estado'            => $estado,

                ]);
                usleep(1000);
                $progressBar->advance();
            }
            $firstLine = false;
        }
        fclose($csvFile2);
        $progressBar->finish();
        $this->command->getOutput()->writeln("");
        $this->command->getOutput()->writeln("Importación Finalizada");

    }
}
