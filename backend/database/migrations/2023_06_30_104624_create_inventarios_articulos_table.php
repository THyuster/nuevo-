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
        Schema::create('inventarios_articulos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('grupo_contable_id');
            $table->integer('grupo_articulo_id');
            $table->integer('tipo_articulo_id');
            $table->integer('unidad_id');
            $table->integer('marca_id');
            $table->date('codigo');
            $table->date('descripcion');
            $table->decimal('existencia_minima', 8, 2);
            $table->decimal('existencia_maxima', 8, 2);
            $table->decimal('precio_promedio', 8, 2);
            $table->decimal('ultimo_precio', 8, 2);
            $table->string('ruta_imagen', 100);
            $table->date('fecha_modificacion');
            $table->string('observaciones', 200);
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
        Schema::dropIfExists('inventarios_articulos');
    }
};
