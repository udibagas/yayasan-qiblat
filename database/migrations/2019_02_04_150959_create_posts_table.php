<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
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
            $table->integer('post_category_id')->unsigned();
            $table->string('title');
            $table->string('title_en')->nullable();
            $table->string('title_ar')->nullable();
            $table->string('slug');
            $table->string('slug_en')->nullable();
            $table->string('slug_ar')->nullable();
            $table->text('content');
            $table->text('content_en')->nullable();
            $table->text('content_ar')->nullable();
            $table->string('image')->nullable();
            $table->integer('user_id')->unsigned();
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
        Schema::dropIfExists('posts');
    }
}
