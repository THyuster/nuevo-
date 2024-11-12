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
        Schema::create('logistica_vehiculos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->date('afiliacion');
            $table->date('operacion');
            $table->date('actualizacion');
            $table->date('desvinculacion', 100);
            $table->integer('conductor_id');
            $table->integer('propietario_id');
            $table->integer('conductor_identificacion');
            $table->integer('propietario_identificacion');
            $table->string('conductor_apellidos', 100);
            $table->string('propietario_apellidos', 100);
            $table->string('conductor_nombres', 100);
            $table->string('propietario_nombres', 100);
            $table->string('conductor_telefono', 100);
            $table->string('propietario_telefono', 100);
            $table->string('conductor_email', 100);
            $table->string('propietario_email', 100);
            $table->integer('matricula');
            $table->boolean('estado');
            $table->boolean('propio');
            $table->boolean('modificado');
            $table->string('vehiculo_placa', 100);
            $table->string('vehiculo_marca', 100);
            $table->string('vehiculo_modelo', 100);
            $table->string('vehiculo_linea', 100);
            $table->string('vehiculo_color', 300);
            $table->string('vehiculo_serial_motor', 300);
            $table->string('vehiculo_serial_chasis', 300);
            $table->string('gps_empresa', 300);
            $table->string('gps_usuario', 300);
            $table->string('gps_id', 300);
            $table->string('gps_password', 300);
            $table->string('gps_numero', 300);
            $table->string('vehiculo_clase', 300);
            $table->string('tipo_contrato', 300);
            $table->string('observacion', 300);
            $table->string('ejes', 300);
            $table->string('combustible', 300);
            $table->string('blindaje', 300);
            $table->string('soat_empresa', 300);
            $table->string('soat_valor', 300);
            $table->string('soat_ini', 300);
            $table->string('soat_fin', 300);
            $table->string('gases_empresa', 300);
            $table->string('gases_valor', 300);
            $table->string('gases_ini', 300);
            $table->string('gases_fin', 300);
            $table->string('seguro_empresa', 300);
            $table->string('seguro_valor', 300);
            $table->string('seguro_ini', 300);
            $table->string('seguro_fin', 300);
            $table->string('cilindraje', 300);
            $table->string('tara', 300);
            $table->string('pasajeros', 300);
            $table->string('km_ini', 300);
            $table->integer('trailer_id');
            $table->string('trailer_modelo', 300);


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logistica_vehiculos');
    }
};