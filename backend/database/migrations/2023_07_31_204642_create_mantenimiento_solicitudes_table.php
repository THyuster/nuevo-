<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mantenimiento_solicitudes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->date('fecha_solicitud');
            $table->date('fecha_cierre');
            $table->integer('estado');
            $table->integer('tercero_id');
            $table->integer('centro_trabajo_id');
            $table->string('prioridad', 50);
            $table->integer('tipo_solicitud_id');
            $table->integer('equipo_id');
            $table->integer('vehiculo_id');
            $table->string('observacion', 300);
            $table->string('ruta_imagen', 100);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimiento_solicitudes');
    }
};