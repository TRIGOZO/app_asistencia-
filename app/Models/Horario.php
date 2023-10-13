<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Horario extends Model
{
    use HasFactory;

     protected $fillable = [
        'nro',
        'horario_personal_id',
        'fecha',
        'dia',
        'hora_entrada',
        'hora_salida',
        'total_horas'
    ];
    /**
     * Get the horario_personal that owns the Horario
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function horario_personal(): BelongsTo
    {
        return $this->belongsTo(HorarioPersonal::class, 'horario_personal_id');
    }
}
