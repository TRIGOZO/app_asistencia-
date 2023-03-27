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
        Schema::create('tipo_guardias', function (Blueprint $table) {
            $table->id();
            $table->string('abreviatura', 4);
            $table->string('nombre', 10);
            $table->tinyInteger('es_feriado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_guardias');
    }
};
