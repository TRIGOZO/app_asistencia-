<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Permiso extends Model
{
    use HasFactory;
    protected $fillable = [
        'personal_id',
        'fecha_desde',
        'hora_inicio',
        'fecha_hasta',
        'hora_hasta',
        'tipo_permiso_id',
        'motivo',
        'establecimiento_id',
        'estado',
    ];
    public function personal(): BelongsTo
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }
    public function tipopermiso(): BelongsTo
    {
        return $this->belongsTo(TipoPermiso::class, 'tipo_permiso_id');
    }    
}
