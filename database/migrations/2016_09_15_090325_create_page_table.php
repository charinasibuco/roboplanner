<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages',function(Blueprint $table){
            $table->increments('id');
            $table->integer('parent_id');
            $table->string('title');
            $table->string('slug');
            $table->string('content');
            $table->enum('status',['published','hidden']);
            $table->string('template');
            $table->string('order');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pages');
    }
}

