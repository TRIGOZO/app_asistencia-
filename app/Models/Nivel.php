<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    use HasFactory;
    protected $table = 'niveles';
    protected $fillable = [
        'abreviatura',
        'nombre',
        'tipo_nivel_id'
    ];
    public function tiponivel()
    {
        return $this->belongsTo(TipoNivel::class, 'tipo_nivel_id');
    }
}
