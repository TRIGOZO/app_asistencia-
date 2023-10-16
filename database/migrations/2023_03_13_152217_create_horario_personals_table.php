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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->date('fecha_desde');
            $table->date('fecha_hasta');
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
