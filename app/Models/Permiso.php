<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
