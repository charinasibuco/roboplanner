<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WealthScoreComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wealth_score_comments',function(Blueprint $table){
            $table->increments('id');
            $table->enum('list',['why_did_i_get_this_score','what_can_i_do_to_improve']);
            $table->enum('wealth_score',['liquidity','investments','college','cashflow','legacy','insurance','retirement']);
            $table->string('description');
            $table->string('trigger_score');
            $table->enum('trigger_scope',['high','low']);
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
