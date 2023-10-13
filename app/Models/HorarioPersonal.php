<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HorarioPersonal extends Model
{
    use HasFactory;
    protected $fillable=['personal_id','turno_horario_id', 'tolerancia_antes', 'tolerancia_despues', 'es_lactancia'];

    /**
     * Get the Personal that owns the HorarioPersonal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function personal(): BelongsTo
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }

    public function turno_horario(): BelongsTo
    {
        return $this->belongsTo(HorarioTurno::class, 'turno_horario_id');
    }
}
