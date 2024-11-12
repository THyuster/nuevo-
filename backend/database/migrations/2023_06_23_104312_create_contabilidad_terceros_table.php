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
        Schema::create('contabilidad_terceros', function (Blueprint $table) {
            $table->id();
            $table->timestamps();


            $table->date('fecha_actualizacion');
            $table->date('fecha_creacion');
            $table->date('fecha_inactivo');
            $table->integer('tipo_identificacion');
            $table->string('identificacion', 20);
            $table->string('digito_verificacion', 20);
            $table->string('nombre_completo', 120);
            $table->string('apellido1', 20);
            $table->string('apellido2', 20);
            $table->string('nombre1', 20);
            $table->string('nombre2', 20);
            $table->string('naturaleza_juridica', 1);
            $table->date('fecha_nacimiento');
            $table->string('grupo_sanguineo', 3);
            $table->string('direccion', 300);
            $table->string('email', 60);
            $table->string('telefono_fijo', 40);
            $table->string('movil', 20);
            $table->integer('municipio');
            $table->boolean('proveedor');
            $table->boolean('cliente');
            $table->boolean('cobrador');
            $table->boolean('fiador');
            $table->boolean('tomador');
            $table->boolean('vendedor');
            $table->boolean('conductor');
            $table->boolean('propietario');
            $table->boolean('empleado');
            $table->string('observacion', 300);
            $table->boolean('estado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contabilidad_terceros');
    }
};
