<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HorarioPersonal extends Model
{
    use HasFactory;
    protected $fillable=['user_id', 'personal_id','fecha_desde', 'fecha_hasta', 'es_lactancia'];

    /**
     * Get the Personal that owns the HorarioPersonal
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function personal(): BelongsTo
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }    


}
