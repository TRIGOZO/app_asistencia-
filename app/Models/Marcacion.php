<?php

namespace App\Models;

use App\Http\Traits\MarcacionTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Marcacion extends Model
{
    use HasFactory, MarcacionTrait;

    protected $table='marcaciones';

    protected $fillable = [
        'personal_id',
        'establecimiento_id',
        'fecha_hora',
        'tipo',
        'serial',
        'ip',
    ];
    /**
     * Get the personal that owns the Marcacion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function personal(): BelongsTo
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }
    /**
     * Get the establecimiento that owns the Marcacion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function establecimiento(): BelongsTo
    {
        return $this->belongsTo(Establecimiento::class, 'establecimiento_id');
    }

}
