<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->increments('id');
            $table->float('tax_rate', 8, 2)->default(0.00);
            $table->string('single_filters_from')->nullable();
            $table->string('single_filters_to')->nullable();
            $table->string('married_filling_jointly_from')->nullable();
            $table->string('married_filling_jointly_to')->nullable();
            $table->string('married_filling_separately_from')->nullable();
            $table->string('married_filling_separately_to')->nullable();
            $table->string('head_of_household_from')->nullable();
            $table->string('head_of_household_to')->nullable();
            $table->date('due_date');
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
        Schema::drop('taxes');
    }
}
