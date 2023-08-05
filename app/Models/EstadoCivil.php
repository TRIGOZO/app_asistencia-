<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoCivil extends Model
{
    use HasFactory;
    protected $table = "estados_civiles";
    protected $fillable = [ 'id', 'nombre'];

    public function personales(): HasMany
    {
        return $this->hasMany(Personal::class);
    }
}
