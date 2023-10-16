<?php

namespace Database\Seeders;

use App\Models\Establecimiento;
use App\Models\Horario;
use App\Models\HorarioPersonal;
use App\Models\HorarioTurno;
use App\Models\Personal;
use App\Models\TipoTrabajador;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HorarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        setlocale(LC_TIME, 'es_ES.utf8');
        $idtipotrabajador = TipoTrabajador::where('nombre', 'Administrativo')->value('id');
        $idestablecimiento = Establecimiento::where('nombre', 'SEDE RED SALUD HUANUCO')->value('id');
        $administrativos = Personal::where('tipo_trabajador_id', $idtipotrabajador)
        ->where('establecimiento_id', $idestablecimiento)
        ->get();
        $anio = Carbon::now()->year;
        $fechaInicio = Carbon::create($anio, 9, 1);
        $fechaFin = Carbon::create($anio, 9, 1)->endOfMonth();
        //$horarios=[];
        $diasdelmes = Carbon::create($anio, 9, 1)->daysInMonth;
        $cantidad = $administrativos->count();
        $totalcontador=($diasdelmes*$cantidad)*2;
        $this->command->getOutput()->writeln('Iniciando carga de Horarios Administrativos...');
        $this->command->getOutput()->writeln('Cantidad de registros: '.$totalcontador);
        $progressBar = $this->command->getOutput()->createProgressBar($totalcontador);
        $registros = HorarioTurno::with('tipo_turno:id,abreviatura')
        ->whereHas('tipo_turno', function ($query){
            $query->whereIn('abreviatura', ['M', 'T']);
        })->get();
        $progressBar->start();
        foreach($administrativos as $rowadministrativo){
            $horariopersonal = HorarioPersonal::Create([
                'personal_id'       => $rowadministrativo->id,
                'user_id'           => 1,
                'fecha_desde'       => $fechaInicio,
                'fecha_hasta'       => $fechaFin,
            ]);
            //$fecha=$fechaInicio;
            $fecha = $fechaInicio->copy();
            while ($fecha->lte($fechaFin)) {
                foreach($registros as $row){
                    if ($this->esDiaHabilitado($fecha->dayOfWeek, $row)) {
                        $nombreDia = $fecha->formatLocalized('%A');
                        Horario::create([
                            'nombredia' => $nombreDia,
                            'horario_personal_id' => $horariopersonal->id,
                            'turno_horario_id'    => $row->id,
                            'fecha' => $fecha->toDateString(),
                            'dia' => $fecha->dayOfWeek,
                            'hora_entrada' => $row->horaentrada,
                            'hora_salida' => $row->horasalida,
                            'total_horas' => $row->totalhoras,
                        ]);
                        usleep(1000);
                        $progressBar->advance();
                    }
                }
                $fecha->addDay();
            }            
        }
        //Horario::insert($horarios);
        $progressBar->finish();
        $this->command->getOutput()->writeln("");
        $this->command->getOutput()->writeln("Importación Finalizada");
    }
    private function esDiaHabilitado($dayOfWeek, $horarioturno)
    {
        switch ($dayOfWeek) {
            case 0: return $horarioturno->diadomingo == 1;
            case 1: return $horarioturno->dialunes == 1;
            case 2: return $horarioturno->diamartes == 1;
            case 3: return $horarioturno->diamiercoles == 1;
            case 4: return $horarioturno->diajueves == 1;
            case 5: return $horarioturno->diaviernes == 1;
            case 6: return $horarioturno->diasabado == 1;
            default: return false;
        }
    }
}
