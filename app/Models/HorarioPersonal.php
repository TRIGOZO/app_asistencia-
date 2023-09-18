<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HorarioPersonal extends Model
{
    use HasFactory;
    protected $fillable=['personal_id','tipo_turno_id', 'tolerancia_antes', 'tolerancia_despues', 'es_lactancia'];

    /**
     * Get the Personal that owns the HorarioPersonal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function personal(): BelongsTo
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }

    public function tipo_turno(): BelongsTo
    {
        return $this->belongsTo(TipoTurno::class, 'tipo_turno_id');
    }
}
