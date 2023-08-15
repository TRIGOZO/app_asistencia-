<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoNivel extends Model
{
    use HasFactory;
    protected $tabla = 'tipo_niveles';
    protected $fillable = [
        'nombre'
    ];
}
