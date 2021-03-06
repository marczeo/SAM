<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriverTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver', function(Blueprint $table){
          $table->increments('id');
          $table->integer('user_id')->unsigned();
          $table->integer('route_car_id')->unsigned();
          $table->integer('concessionaire_id')->unsigned();
        });

        Schema::table('driver', function(Blueprint $table){
          $table->foreign('user_id')->references('id')->on('users')
            ->onDelete('restrict')->onUpdate('cascade');
          $table->foreign('route_car_id')->references('id')->on('route_car')
            ->onDelete('restrict')->onUpdate('cascade');
          $table->foreign('concessionaire_id')->references('id')->on('users')
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
        Schema::dropIfExists('driver');
    }
}
