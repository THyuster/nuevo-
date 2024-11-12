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
        Schema::create('mantenimiento_tipos_ordenes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('codigo',100);
            $table->string('descripcion', 200);
            $table->string('tipo_acta_modal',200);
            $table->boolean('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimiento_tipos_ordenes');
    }
};
