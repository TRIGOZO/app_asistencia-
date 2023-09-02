<?php

namespace Database\Seeders;

use App\Models\Departamento;
use App\Models\Distrito;
use App\Models\Provincia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UbigeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = fopen(storage_path('app/archivos/Ubigeo-Peru.csv'),'r');

        $nro_registros = -1;
        while (($datum = fgetcsv($csvFile, 555, ',')) !== false)
        {
            $nro_registros +=1;
        }
        fclose($csvFile);

        $this->command->getOutput()->writeln('Iniciando Importación de Ubigeo...');
        $this->command->getOutput()->writeln('Cantidad de registros: '.$nro_registros);

        DB::unprepared("SET FOREIGN_KEY_CHECKS = 0;");
        Distrito::truncate();
        DB::statement("SET foreign_key_checks=1");
        $this->command->getOutput()->writeln('Datos Limpiados de Distritos...');

        DB::unprepared("SET FOREIGN_KEY_CHECKS = 0;");
        Provincia::truncate();
        DB::statement("SET foreign_key_checks=1");
        $this->command->getOutput()->writeln('Datos Limpiados de Provincias...');

        DB::unprepared("SET FOREIGN_KEY_CHECKS = 0;");
        Departamento::truncate();
        DB::statement("SET foreign_key_checks=1");
        $this->command->getOutput()->writeln('Datos Limpiados de Departamentos...');


        $csvFile2 = fopen(storage_path('app/archivos/Ubigeo-Peru.csv'),"r");

        $progressBar = $this->command->getOutput()->createProgressBar($nro_registros);
        $this->command->getOutput()->writeln("Importando Datos de Ubigeo... ");

        $progressBar->start();
        $firstLine = true;

        while(($fila  = fgetcsv($csvFile2,2000,";")) !== false) {
            if(!$firstLine)
            {
                $registro = explode(",",(string)$fila[0]);

                $cod_departamento =substr($registro[0],0,2);
                $cod_provincia = substr($registro[0],0,4);
                $cod_distrito = $registro[0];

                $departamento =Departamento::where('codigo',$cod_departamento)->first();

                //$this->command->getOutput()->writeln($registro[0]);

                if(!$departamento)
                {
                    $departamento = Departamento::Create([
                        'codigo' => $cod_departamento,
                        'nombre' => $registro[3]
                    ]);
                }
                $provincia = Provincia::where('codigo',$cod_provincia)->first();
                if(!$provincia && substr($cod_provincia,-2) != '00')
                {
                    $provincia = Provincia::Create([
                        'codigo' => $cod_provincia,
                        'departamento_id' => $departamento->id,
                        'nombre' => $registro[2]
                    ]);
                }

                $distrito = Distrito::where('codigo', $cod_distrito)->first();
                if(!$distrito && substr($cod_distrito,-2) != '00')
                {
                    $distrito  = Distrito::Create([
                        'codigo' => $cod_distrito,
                        'provincia_id' => $provincia->id,
                        'nombre' => $registro[1]
                    ]);
                }

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