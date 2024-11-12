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
        Schema::create('erp_migraciones', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('tabla',50);
            $table->string('campo',50);
            $table->string('atributo',50);
            $table->string('accion',30);
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
        Schema::dropIfExists('erp_migraciones');
    }
};
