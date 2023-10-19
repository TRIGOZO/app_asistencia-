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
        $archivoLeer = storage_path('app/archivos/todosetiembre.txt');
        //$archivoLeer = storage_path('app/archivos/marcacionesprevias.txt');
        $this->command->getOutput()->writeln('Iniciando Importación de Marcaciones...');
        
        $archivo = file($archivoLeer);
        $cantidad_filas = count($archivo);
        $fila_ulti=end($archivo);
        $i=0;
        $progressBar = $this->command->getOutput()->createProgressBar($cantidad_filas);
        $progressBar->start();
        foreach($archivo as $line_num=>$linea){
            if($i<=$cantidad_filas-2){
                $dni = str_pad(substr($linea, 1, 8), 8, '0', STR_PAD_LEFT);
                $fecha = substr($linea, 10, 19);
                Marcacion::firstorCreate([
                    'personal_id'           => Personal::where('numero_dni', $dni)->value('id'),
                    'establecimiento_id'    => Establecimiento::where('nombre', 'SEDE RED SALUD HUANUCO')->value('id'),
                    'fecha_hora'            => $fecha,
                    'serial'                => 'AF4C172960193',
                    'ip'                    => '192.168.2.252'
                ]);
                $i++;
                usleep(600);
                $progressBar->advance();
            }
        }
        $progressBar->finish();

    }
}
