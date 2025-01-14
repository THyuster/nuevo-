<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contabilidad_empresas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('tercero_id');            
            $table->string('razon_social',100);            
            $table->string('direccion',100);            
            $table->string('telefono',100);            
            $table->string('email',100);            

            $table->boolean('estado');

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contabilidad_empresas');
    }
};
