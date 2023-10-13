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
        Schema::create('horario_personals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personal_id')->constrained('personales')->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreignId('turno_horario_id')->nullable()->constrained('turno_horario')->onDelete('set null')
                ->onUpdate('cascade');
            $table->tinyInteger('tolerancia_antes')->default(5);
            $table->tinyInteger('tolerancia_despues')->default(5);
            $table->tinyInteger('es_lactancia')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horario_personals');
    }
};
