<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarouselButtonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carousel_buttons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('carousel_id', false, true);
            $table->string('label', 30);
            $table->string('label_en', 30)->nullable();
            $table->string('label_ar', 30)->nullable();
            $table->string('type', 20);
            $table->string('url');
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
        Schema::dropIfExists('carousel_buttons');
    }
}
