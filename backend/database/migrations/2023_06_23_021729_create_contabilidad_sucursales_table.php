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
        Schema::create('contabilidad_sucursales', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('municipio_id');
            $table->string('codigo',50);
            $table->string('descripcion',100);
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
        Schema::dropIfExists('contabilidad_sucursales');
    }
};
