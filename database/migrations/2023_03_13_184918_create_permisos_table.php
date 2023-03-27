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
        Schema::create('permisos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personal_id')->nullable()->constrained('personales')->onDelete('set null')
            ->onUpdate('cascade');
            $table->date('fecha_desde');
            $table->time('hora_inicio');
            $table->date('fecha_hasta');
            $table->time('hora_hasta');
            $table->foreignId('tipo_permiso_id')->nullable()->constrained('tipo_permisos')->onDelete('set null')
            ->onUpdate('cascade');
            $table->string('motivo');
            $table->foreignId('establecimiento_id')->nullable()->constrained('establecimientos')->onDelete('set null')
                ->onUpdate('cascade');
            $table->string('estado')->default('SOLICITADO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permisos');
    }
};
