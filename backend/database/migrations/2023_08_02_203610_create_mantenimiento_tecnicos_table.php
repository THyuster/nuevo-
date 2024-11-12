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
        Schema::create('mantenimiento_tecnicos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->date('fecha_inicio');
            $table->date('fecha_final');
            $table->string('observaciones',300);
            $table->string('especialidad', 100);
            $table->boolean('estado');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimiento_tecnicos');
    }
};
