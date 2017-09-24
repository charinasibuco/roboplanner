<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("values",function(Blueprint $table){
            $table->increments("id");
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable()->default(NULL);
            $table->string('value')->nullable()->default(NULL);
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
        //
    }
}
