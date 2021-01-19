<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_serie');
            $table->unsignedBigInteger('prueba_id')->nullable();
            $table->unsignedBigInteger('competencia_id')->nullable();

            $table->foreign('prueba_id')->references('id')->on('pruebas')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('competencia_id')->references('id')->on('competencias')
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
        Schema::dropIfExists('series');
    }
}
