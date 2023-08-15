<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Establecimiento extends Model
{
    use HasFactory;
    protected $fillable=['id', 'nombre', 'microred_id'];
    public function microred(): BelongsTo
    {
        return $this->belongsTo(MicroRed::class,'microred_id');
    }
}
