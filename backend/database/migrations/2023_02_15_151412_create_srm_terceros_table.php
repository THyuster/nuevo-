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
        Schema::create('srm_terceros', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_identificacion',200)->nullable() ;
            $table->string('identificacion',20)->unique();
            $table->string('apellidos',200)->nullable() ;
            $table->string('nombres',200)->nullable() ;
            $table->string('direccion',200)->nullable() ;
            $table->string('telefono',200)->nullable() ;
            $table->string('email',200)->nullable() ;
            $table->string('tipo_tercero',200)->nullable() ;
            $table->string('observaciones',200)->nullable() ;
            $table->string('razon_social',200)->nullable() ;
            $table->string('estado',200)->nullable() ;
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
        Schema::dropIfExists('srm_terceros');
    }
};
