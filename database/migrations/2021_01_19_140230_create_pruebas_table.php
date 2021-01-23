<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePruebasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * CAMBIAR TIPO DE NOMBRE_PRUEBA
         */
        Schema::create('pruebas', function (Blueprint $table) {
            $table->id();
            $table->integer('nombre_prueba');
            $table->integer('distancia');
            $table->string('estilo');
            $table->string('sexo');
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->string('nivel');
            $table->unsignedBigInteger('competencia_id')->nullable();

            $table->foreign('competencia_id')->references('id')->on('competencias')
                       ->onDelete('cascade')
                       ->onUpdate('cascade');

            $table->foreign('categoria_id')->references('id')->on('categorias')
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
        Schema::dropIfExists('pruebas');
    }
}
