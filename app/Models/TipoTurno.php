<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    /**
     * Get all of the horadio for the TipoTurno
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function horario(): HasMany
    {
        return $this->hasMany(HorarioTurno::class, 'tipo_turno_id');
    }

}
