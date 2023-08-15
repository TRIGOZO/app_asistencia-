<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoTrabajador extends Model
{
    use HasFactory;
    protected $tabla = 'tipo_trabajadores';
    protected $fillable = [
        'nombre'
    ];
}
