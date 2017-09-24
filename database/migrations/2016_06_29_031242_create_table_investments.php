<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInvestments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investments',function(Blueprint $table){
                $table->increments('id');
                $table->text('data');
                $table->string('name');
                $table->integer('point_start');
                $table->float('initial');
                $table->float('current');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('investments');
    }
}
