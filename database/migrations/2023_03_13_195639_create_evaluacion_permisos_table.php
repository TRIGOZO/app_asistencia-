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
        Schema::create('evaluacion_permisos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluacion_permiso_id')->constrained('permisos')->onDelete('cascade')
            ->onUpdate('cascade');
            $table->foreignId('personal_id')->nullable()->constrained('personales')->onDelete('set null')
            ->onUpdate('cascade');
            $table->string('comentario')->default('NINGUNO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluacion_permisos');
    }
};
