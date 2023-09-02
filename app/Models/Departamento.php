<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Departamento extends Model
{
    use HasFactory;

    protected $fillable = ['codigo','nombre'];

    /**
     * Get all of the provincias for the Departamento
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function provincias(): HasMany
    {
        return $this->hasMany(Provincia::class);
    }

    /**
     * Get all of the distritos for the Departamento
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function distritos(): HasManyThrough
    {
        return $this->hasManyThrough(Distrito::class, Provincia::class);
    }

}
