<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Personal extends Model
{
    use HasFactory;
    protected $table='personales';
    protected $fillable = [
        'numero_dni',
        'pin',
        'uid',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'sexo',
        'fecha_nacimiento',
        'estado_civil_id',
        'direccion',
        'telefono',
        'celular',
        'email',
        'tipo_trabajador_id',
        'tienehijos',
        'profesion_id',
        'nivel_id',
        'sueldo',
        'condicion_laboral_id',
        'fecha_inicio',
        'fecha_fin',
        'establecimiento_id',
        'cargo_id',
        'es_activo',
    ];
    public function estado_civil(): BelongsTo
    {
        return $this->belongsTo(EstadoCivil::class, 'estado_civil_id');
    }
    public function nombre_estado(){
        return $this->estado_civil()->first()->nombre;
    }
    public function profesion(): BelongsTo
    {
        return $this->belongsTo(Profesion::class, 'profesion_id');
    }   
    public function cargo(): BelongsTo
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }
    public function establecimiento(): BelongsTo
    {
        return $this->belongsTo(Establecimiento::class, 'establecimiento_id');
    }  
    public function condicion(): BelongsTo
    {
        return $this->belongsTo(CondicionLaboral::class, 'condicion_laboral_id');
    }
    public function nivel():BelongsTo
    {
        return $this->belongsTo(Nivel::class, 'nivel_id');
    }
    /**
     * Get all of the marcaciones for the Personal
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function marcaciones(): HasMany
    {
        return $this->hasMany(Marcacion::class, 'personal_id', 'id');
    }
}
