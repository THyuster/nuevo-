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
        Schema::create('erp_licenciamientos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('codigo',50);
            $table->string('descripcion',100);  
            $table->date('fecha_inicial');
            $table->date('fecha_final');          
            $table->boolean('estado');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('erp_licenciamientos');
    }
};
