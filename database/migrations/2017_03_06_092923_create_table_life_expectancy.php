<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLifeExpectancy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("life_expectancy",function(Blueprint $table){
            $table->increments('id');
            $table->string("exact_age");
            $table->enum("sex",["Female","Male"]);
            $table->string("death_probability");
            $table->string("number_of_lives");
            $table->string("life_expectancy");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("life_expectancy");
    }
}
