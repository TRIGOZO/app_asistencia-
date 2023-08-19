<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CondicionLaboral extends Model
{
    use HasFactory;
    protected $table='condicion_laborales';
    protected $fillable=['nombre'];
}
