<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscripcionPruebasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscripcion_pruebas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('competidor_id')->nullable();
            $table->unsignedBigInteger('prueba_id')->nullable();
            $table->unsignedBigInteger('competencia_id')->nullable();
            
            $table->foreign('competencia_id')->references('id')->on('competencias')
                       ->onDelete('cascade')
                       ->onUpdate('cascade');
            $table->foreign('prueba_id')->references('id')->on('pruebas')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('competidor_id')->references('id')->on('competidors')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inscripcion_pruebas');
    }
}
