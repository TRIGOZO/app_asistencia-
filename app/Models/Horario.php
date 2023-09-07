<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
