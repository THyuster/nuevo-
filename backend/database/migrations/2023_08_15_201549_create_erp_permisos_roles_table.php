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
        Schema::create('erp_permisos_roles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('rol_id');
            $table->integer('user_id');
            $table->integer('empresa_id');

            $table->boolean('estado');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('erp_permisos_roles');
    }
};
