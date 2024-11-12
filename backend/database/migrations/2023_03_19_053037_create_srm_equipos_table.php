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
        Schema::create('srm_equipos', function (Blueprint $table) {

            $table->id();
            $table->timestamps();

            $table->date('fecha_adquicicion' )->nullable() ;
            $table->date('fecha_instalacion' )->nullable() ;
            $table->string('activo_fijo' , 50 )->nullable() ;
            $table->string('serial_interno' , 50 )->unique()->default('X') ;
            $table->string('serial_equipo' , 50 )->nullable() ;
            $table->string('modelo' , 50 )->nullable() ;
            $table->string('marca' , 50 )->nullable() ;
            $table->string('potencia' , 50 )->nullable() ;
            $table->string('proveedor' , 100 )->nullable() ;
            $table->string('mantenimiento' , 100 )->nullable() ;
            $table->integer('horometro')->nullable()->default(0) ;
            $table->integer('costo')->nullable()->default(0) ;
            $table->string('combustible' , 30 )->nullable()->default(0) ;
            $table->string('uso_diario' , 50 )->nullable() ;
            $table->string('estado' , 50 )->nullable() ;
            $table->string('upm' , 100 )->nullable() ;
            $table->string('area' , 100 )->nullable() ;
            $table->string('labor' , 100 )->nullable() ;
            $table->string('administrador' , 100 )->nullable() ;
            $table->string('ingeniero' , 100 )->nullable() ;
            $table->string('jefe_mantenimiento' , 100 )->nullable() ;
            $table->string('operador' , 100 )->nullable() ;
            $table->string('observaciones' , 500 )->nullable() ;
            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('srm_equipos');
    }
};
