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
        Schema::create('erp_permisos_modulos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('user_id');
            $table->string('modulo',50);
            $table->string('estado',30);            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('erp_permisos_modulos');
    }
};
