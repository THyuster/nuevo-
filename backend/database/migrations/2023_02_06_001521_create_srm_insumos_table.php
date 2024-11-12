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
        Schema::create('srm_insumos', function (Blueprint $table) {
            
            $table->id();
            $table->timestamps();

            $table->string('codigo', 20 )->nullable()->default('X')->unique() ;
            $table->string('descripcion',200 )->nullable()->default('X') ;
            $table->integer('grupo')->nullable()->default(0) ;
            $table->integer('unidad')->nullable()->default(0) ;
            $table->string('serial',50)->nullable() ;
            $table->decimal('existencia',12,2)->nullable()->default(0) ;
            $table->decimal('existencia_minima',12,2)->nullable()->default(0) ;
            $table->decimal('existencia_maxima',12,2)->nullable()->default(0) ;
            $table->decimal('precio_actual',12,2)->nullable()->default(0) ;
            $table->decimal('precio_primedio',12,2)->nullable()->default(0) ;
            $table->string('observaciones',300)->nullable() ;
            $table->string('estado')->nullable()->default('INACTIVO') ;

            
        });
    }


    


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('srm_insumos');
    }
};
