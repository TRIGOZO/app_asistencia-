<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoTurno extends Model
{
    use HasFactory;
    protected $tabla = 'tipo_turnos';
    protected $fillable = [
        'abreviatura',
        'nombre',
        'diastolerancia',
        'descuento',
        'guardia',
        'permiso',
        'horasantesdescansa',
        'horasdespuesdescansa',
        'horaasistencial',
        'horaadministrativo',
        'nroturnos',
    ];
    public function horario()
    {
        return $this->hasMany(HorarioTurno::class);
    }
}
