<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MicroRed extends Model
{
    protected $table = "microredes";
    use HasFactory;
    protected $fillable=['id', 'nombre'];
    public function red()
    {
        return $this->belongsTo(Red::class, 'red_id');
    }
}
