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
        Schema::create('nomina_centros_trabajos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('codigo',50);
            $table->string('descripcion',100);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nomina_centros_trabajos');
    }
};
