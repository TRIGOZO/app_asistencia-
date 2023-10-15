<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioTurno extends Model
{
    use HasFactory;
    protected $table='turno_horario';
    protected $fillable=[
        'tipo_turno_id',
        'horaentrada',
        'horasalida',
        'toleranciaantes',
        'toleranciadespues',
        'inicioentrada',
        'finentrada',
        'iniciosalida',
        'finsalida',
        'dialunes',
        'diamartes',
        'diamiercoles',
        'diajueves',
        'diaviernes',
        'diasabado',
        'diadomingo',
        'totalhoras',
    ];
    public function tipo_turno()
    {
        return $this->belongsTo(TipoTurno::class, 'tipo_turno_id');
    }

}
