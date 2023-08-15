<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoGuardia extends Model
{
    use HasFactory;
    protected $tabla = 'tipo_guardias';
    protected $fillable = [
        'abreviatura',
        'nombre'
    ];
}
