<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Establecimiento extends Model
{
    use HasFactory;
    protected $fillable=['id', 'nombre', 'microred_id'];
    public function microred(): BelongsTo
    {
        return $this->belongsTo(MicroRed::class,'microred_id');
    }
    /**
     * Get all of the marcaciones for the Establecimiento
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function marcaciones(): HasMany
    {
        return $this->hasMany(Marcacion::class, 'establecimiento_id', 'id');
    }
}
