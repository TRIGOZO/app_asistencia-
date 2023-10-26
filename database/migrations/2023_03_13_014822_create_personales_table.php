<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('personales', function (Blueprint $table) {
            $table->id();
            $table->string('numero_dni',15)->unique();
            $table->char('pin', 4)->default('1111');
            $table->unsignedInteger('uid')->nullable();
            $table->string('nombres');
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->char('sexo', 1)->default('M');
            $table->date('fecha_nacimiento')->default('2023-10-01');
            $table->foreignId('estado_civil_id')->default(1)->constrained('estados_civiles')->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('direccion')->nullable();
            $table->string('telefono', 9)->nullable();
            $table->string('celular', 9)->nullable();
            $table->string('observacion')->default('Ninguno');
            $table->string('email')->nullable();
            $table->foreignId('tipo_trabajador_id')->nullable()->constrained('tipo_trabajadores')->onDelete('set null')
                ->onUpdate('cascade');
            $table->char('tienehijos', 2)->default('NO');
            $table->foreignId('profesion_id')->nullable()->constrained('profesiones')->onDelete('set null')
                ->onUpdate('cascade');
            $table->string('nivel_id')->nullable();
            $table->decimal('sueldo')->default(0);
            $table->foreignId('condicion_laboral_id')->nullable()->constrained('condicion_laborales')->onDelete('set null')
                ->onUpdate('cascade');
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->foreignId('establecimiento_id')->nullable()->constrained('establecimientos')->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('cargo_id')->nullable()->constrained('cargos')->onDelete('set null')
                ->onUpdate('cascade');
            $table->unsignedTinyInteger('es_activo')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personales');
    }
};