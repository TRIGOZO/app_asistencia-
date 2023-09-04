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
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->integer('nro'); //contara desde cada dia
            $table->foreignId('personal_id')->constrained('personales')->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreignId('tipo_turno_id')->nullable()->constrained('tipo_turnos')->onDelete('set null')
                ->onUpdate('cascade');
            $table->date('fecha');
            $table->integer('dia');//numero de dia por semana
            $table->time('hora_entrada');
            $table->time('hora_salida');
            $table->time('total_horas');
            $table->tinyInteger('tolerancia_antes')->default(5);
            $table->tinyInteger('tolerencia_despues')->default(5);
            $table->tinyInteger('es_lactancia')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
