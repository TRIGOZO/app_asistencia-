<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tipo_turnos', function (Blueprint $table) {
            $table->id();
            $table->string('abreviatura', 4)->unique();
            $table->string('nombre');
            $table->integer('diastolerancia');
            $table->integer('descuento');
            $table->integer('guardia');
            $table->integer('permiso');
            $table->integer('horasantesdescansa');
            $table->integer('horasdespuesdescansa');
            $table->integer('horaasistencial');
            $table->integer('horaadministrativo');
            $table->integer('nroturnos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_turnos');
    }
};
