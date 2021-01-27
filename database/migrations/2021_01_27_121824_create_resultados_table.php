<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('competidor_id')->nullable();
            $table->unsignedBigInteger('competencia_id')->nullable();
            $table->time('tiempo')->default('23:59:59');
            $table->integer('puntaje')->default(0);
            $table->unsignedBigInteger('serie_id')->nullable();

            $table->foreign('serie_id')->references('id')->on('series')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('competencia_id')->references('id')->on('competencias')
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
        Schema::dropIfExists('resultados');
    }
}
