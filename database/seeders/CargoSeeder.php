<?php

namespace Database\Seeders;
use App\Models\Cargo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cargo = Cargo::firstOrCreate(['nombre'=> 'POR DEFINIR']);     
        $cargo = Cargo::firstOrCreate(['nombre'=> 'SUPER']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'CIRUJANO DENTISTA I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'PSICOLOGO I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'ENFERMERA/O I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'MEDICO VETERINARIO I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'OBSTETRA I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'ENFERMERA/O IV']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'ENFERMERA/O II']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'MEDICO I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'MEDICO IV']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'TECNICO/A ADMINIST. I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'TECNICO/A ADMINIST. III']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'TECNICO/A ADMINIST. II']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'AUX. DE CONTABILIDAD I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'TEC. EN ENFERMERIA I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'TEC. SANITARIO I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'DIRECTOR/A']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'TECNICO/A EN SOPORTE INFOR']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'ESP. ADMINIST. I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'TEC. EN LABORATORIO I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'PLANIFICADOR I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'TECNICO/A ASISTENCIAL']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'MEDICO II']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'OBSTETRA V']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'OBSTETRA II']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'NUTRICIONISTA']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'CIRUJANO DENTISTA IV']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'ASIST. SOCIAL']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'MEDICO III']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'TEC. EN FARMACIA I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'INSPECTOR SANITARIO I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'CONTADOR/A I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'VERIF.INSTALAC. SANIT. I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'ASIST. EN SERV.DE SALUD I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'AUXILIAR ASISTENCIAL']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'ASIST. ADMINIST. I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'TEC. EN NUTRICION I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'AUX. DE SIST. ADMINIST. I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'TEC. SANITARIO II']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'OBSTETRA']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'CIRUJANO DENTISTA']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'AUX. DE ENFERMERIA I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'TEC. SEGURIDAD I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'PSICOLOGO II']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'BIOLOGO']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'ENFERMERA/O III']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'QUIMICO FARMACEUTICO II']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'AUX. DE FARMACIA I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'PILOTO DE AMBULANCIA']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'SECRETARIA I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'TEC. EN ENFERMERIA']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'TRABAJADOR DE SERVIC. I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'DIGITADOR P.A.D. I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'ENFERMERA/O']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'CHOFER I']);
        $cargo = Cargo::firstOrCreate(['nombre'=> 'CIRUJANO DENTISTA II']);   
    }
}
