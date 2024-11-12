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
        Schema::create('erp_menuses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('modulo_id'); 
            $table->string('descripcion',50);
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
        Schema::dropIfExists('erp_menuses');
    }
};
