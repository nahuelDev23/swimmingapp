<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompetenciaIdCancheos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cancheos',function(Blueprint $table){
            $table->unsignedBigInteger('competencia_id')->nullable();
            $table->foreign('competencia_id')->references('id')->on('competencias')
                       ->onDelete('cascade')
                       ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
