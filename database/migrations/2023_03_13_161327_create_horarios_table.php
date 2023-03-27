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
            $table->foreignId('personal_id')->constrained('personales')->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreignId('establecimiento_id')->nullable()->constrained('establecimientos')->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreignId('tipo_turno_id')->nullable()->constrained('tipo_turnos')->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreignId('tipo_guardia_id')->nullable()->constrained('tipo_guardias')->onDelete('set null')
                ->onUpdate('cascade');
            $table->date('fecha');
            $table->integer('dia');
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
