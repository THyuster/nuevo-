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
        Schema::create('erp_vistas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('submenu_id'); 
            $table->string('descripcion',50);
            $table->string('ruta',100); 
            $table->string('encriptacion',100); 
            $table->string('estado',100);
           

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp_vistas');
    }
};