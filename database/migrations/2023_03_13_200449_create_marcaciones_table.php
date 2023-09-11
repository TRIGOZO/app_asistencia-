<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\TipoPermiso;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('marcaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personal_id')->nullable()->constrained('personales')->onDelete('set null')
            ->onUpdate('cascade');
            $table->foreignId('establecimiento_id')->nullable()->constrained('establecimientos')->onDelete('set null')
                ->onUpdate('cascade');
            $table->dateTime('fecha_hora')->nullable();
            $table->string('tipo')->default('ENTRADA');
            $table->string('serial')->nullable();
            $table->string('ip')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marcaciones');
    }
};
