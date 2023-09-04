<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;
    protected $fillable = [
        'nro',
        'personal_id',
        'tipo_turno_id',
        'fecha',
        'dia',
        'hora_entrada',
        'hora_salida',
        'total_horas',
        'tolerancia_antes',
        'tolerancia_despues',
        'es_lactancia',
    ];
}
