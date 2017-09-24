<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Blog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->string('meta_title');
            $table->text('meta_keywords');
            $table->text('meta_description');
            $table->longText('contents');
            $table->enum('status', ['publish', 'hidden']);
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0);
            $table->string('title');
            $table->string('slug');
            $table->integer('sort')->default(0);
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('category_post', function (Blueprint $table) {
            $table->integer('post_id')->unsigned();
            $table->integer('category_id')->unsigned();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');

            $table->primary(['category_id', 'post_id']);
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
        Schema::drop('category_post');
        Schema::drop('posts');
        Schema::drop('categories');
    }
}
