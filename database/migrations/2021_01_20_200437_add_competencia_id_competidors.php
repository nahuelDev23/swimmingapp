<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompetenciaIdCompetidors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('competidors',function(Blueprint $table){
            $table->unsignedBigInteger('competencia_id')->default(0);
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
