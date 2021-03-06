<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelConcessionaireTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('rel_concessionaire', function(Blueprint $table){
        $table->increments('id');
        $table->integer('concessionaire_id')->unsigned();
        $table->integer('route_id')->unsigned();
      });

      Schema::table('rel_concessionaire', function(Blueprint $table){
        $table->foreign('concessionaire_id')->references('id')->on('users')
          ->onDelete('restrict')->onUpdate('cascade');
        $table->foreign('route_id')->references('id')->on('routes')
          ->onDelete('restrict')->onUpdate('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rel_concessionaire');
    }
}
