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
        Schema::create('turno_horario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_turno_id')->constrained('tipo_turnos')->onDelete('cascade')->onUpdate('cascade');
            $table->time('horaentrada');
            $table->time('horasalida');
            $table->integer('toleranciaantes');
            $table->integer('toleranciadespues');
            $table->time('inicioentrada');
            $table->time('finentrada');
            $table->time('iniciosalida');
            $table->time('finsalida');
            $table->integer('dialunes');
            $table->integer('diamartes');
            $table->integer('diamiercoles');
            $table->integer('diajueves');
            $table->integer('diaviernes');
            $table->integer('diasabado');
            $table->integer('diadomingo');
            $table->time('totalhoras');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turno_horario');
    }
};
