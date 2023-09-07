<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioPersonal extends Model
{
    use HasFactory;
    protected $fillable=['personal_id','tipo_turno_id', 'tolerancia_antes', 'tolerancia_despues', 'es_lactancia'];



}
