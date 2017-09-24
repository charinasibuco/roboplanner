<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFlag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('flag',function(Blueprint $table){
            $table->increments('id');
            $table->enum('color',['Red','Yellow']);
            $table->string('description');
            $table->Integer('range');
             $table->string('wealth_score');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('flag');
    }
}
