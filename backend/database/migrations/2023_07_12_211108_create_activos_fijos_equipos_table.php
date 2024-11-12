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
        Schema::create('activos_fijos_equipos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            
            $table->string('codigo', 100);
            $table->string('descripcion', 200);
            $table->integer('grupo_equipo_id');
            $table->date('fecha_adquicicion');
            $table->date('fecha_instalacion');
            $table->string('serial_interno', 100);
            $table->string('serial_equipo', 100);
            $table->string('modelo', 100);
            $table->integer('marca');
            $table->string('potencia', 100);
            $table->integer('proveedor');
            $table->string('mantenimiento', 100);
            $table->decimal('horometro', 8, 2);
            $table->decimal('costo', 8, 2);
            $table->string('combustible', 100);
            $table->string('uso_diario', 100);
            $table->string('upm', 100);
            $table->string('area', 100);
            $table->string('labor', 100);
            $table->integer('administrador');
            $table->integer('ingeniero');
            $table->integer('jefe_mantenimiento');
            $table->integer('operador');
            $table->string('observaciones', 300);
            $table->string('ruta_imagen',300) ;
            $table->boolean('estado') ;

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activos_fijos_equipos');
    }
};