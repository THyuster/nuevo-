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
        Schema::create('contabilidad_afiscals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('empresa_id');

            $table->integer('afiscal');
            $table->string('descripcion',100);            
            
            $table->boolean('estado');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contabilidad_afiscals');
    }
};
