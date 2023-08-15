<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Feriado extends Model
{
    use HasFactory;
    protected $fillable=['nombre', 'establecimiento_id', 'fecha'];

    public function establecimiento(): BelongsTo
    {
        return $this->belongsTo(Establecimiento::class,'establecimiento_id');
    }

}
