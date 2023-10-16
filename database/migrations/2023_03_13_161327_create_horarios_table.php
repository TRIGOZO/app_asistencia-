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
            $table->string('nombredia');
            $table->foreignId('horario_personal_id')->nullable()
            ->constrained('horario_personals')->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreignId('turno_horario_id')->nullable()->constrained('turno_horario')->onDelete('set null')
                ->onUpdate('cascade');         
            $table->date('fecha');
            $table->integer('dia');//numero de dia por semana
            $table->time('hora_entrada');
            $table->time('hora_salida');
            $table->time('total_horas');
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
