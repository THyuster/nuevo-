<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('srm_vehiculos', function (Blueprint $table) {
            $table->id();
            $table->date('afiliacion')->nullable() ;
            $table->date('operacion')->nullable() ;
            $table->date('actualizacion')->nullable() ;
            $table->date('desvinculacion')->nullable() ;
            $table->string('conductor_identificacion' , 30 )->nullable() ;
            $table->string('propietario_identificacion' , 30 )->nullable() ;
            $table->string('conductor_apellidos' , 100 )->nullable() ;
            $table->string('propietario_apellidos' , 100 )->nullable() ;
            $table->string('conductor_nombres' , 100 )->nullable() ;
            $table->string('propietario_nombres' , 100 )->nullable() ;
            $table->string('conductor_telefono' , 30 )->nullable() ;
            $table->string('propietario_telefono' , 30 )->nullable() ;
            $table->string('conductor_email' , 80 )->nullable() ;
            $table->string('propietario_email' , 80 )->nullable() ;
            $table->integer('matricula')->nullable() ;
            $table->string('estado' , 15 )->nullable() ;
            $table->string('propio' , 15 )->nullable() ;
            $table->string('modificado' , 15 )->nullable() ;
            $table->string('vehiculo_placa' , 50 )->unique() ;
            $table->string('vehiculo_marca' , 100 )->nullable() ;
            $table->string('vehiculo_modelo' , 100 )->nullable() ;
            $table->string('vehiculo_linea' , 100 )->nullable() ;
            $table->string('vehiculo_color' , 100 )->nullable() ;
            $table->string('vehiculo_serial_motor' , 100 )->nullable() ;
            $table->string('vehiculo_serial_chasis' , 100 )->nullable() ;
            $table->string('gps_empresa' , 80 )->nullable() ;
            $table->string('gps_usuario' , 100 )->nullable() ;
            $table->string('gps_id' , 100 )->nullable() ;
            $table->string('gps_password' , 100 )->nullable() ;
            $table->string('gps_numero' , 100 )->nullable() ;
            $table->string('vehiculo_clase' , 100 )->nullable() ;
            $table->string('tipo_contrato' , 50 )->nullable() ;
            $table->text('observacion')->nullable() ;
            $table->string('ejes' , 30 )->nullable() ;
            $table->string('combustible' , 30 )->nullable() ;
            $table->string('blindaje' , 30 )->nullable() ;
            $table->string('soat_empresa' , 100 )->nullable() ;
            $table->string('soat_valor' , 100 )->nullable() ;
            $table->date('soat_ini')->nullable() ;
            $table->date('soat_fin')->nullable() ;
            $table->string('gases_empresa' , 100 )->nullable() ;
            $table->string('gases_valor' , 100 )->nullable() ;
            $table->date('gases_ini' )->nullable() ;
            $table->date('gases_fin')->nullable() ;
            $table->string('seguro_empresa' , 100 )->nullable() ;
            $table->string('seguro_valor' , 100 )->nullable() ;
            $table->date('seguro_ini')->nullable() ;
            $table->date('seguro_fin')->nullable() ;
            $table->string('cilindraje' , 50 )->nullable() ;
            $table->string('tara' , 50 )->nullable() ;
            $table->string('pasajeros' , 20 )->nullable() ;
            $table->string('km_ini' , 50 )->nullable() ;
            $table->string('trailer_placa' , 50 )->nullable() ;
            $table->string('trailer_modelo' , 100 )->nullable() ;            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('srm_vehiculos');
    }
};
