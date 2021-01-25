<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetidorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competidors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('competencia_id')->nullable();
            $table->unsignedBigInteger('alumno_id')->nullable();
            $table->unsignedBigInteger('prueba_id')->nullable();
            $table->time('competidor_tiempo')->default('23:59:59');
           
            $table->foreign('prueba_id')->references('id')->on('pruebas')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('alumno_id')->references('id')->on('alumnos')->nullable()
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
        Schema::dropIfExists('competidors');
    }
}
