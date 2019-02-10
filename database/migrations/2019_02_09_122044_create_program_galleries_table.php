<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('program_galleries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('program_id', false, true);
            $table->integer('user_id', false, true);
            $table->string('image_path');
            $table->string('title');
            $table->text('description');
            $table->string('title_en')->nullable();
            $table->text('description_en')->nullable();
            $table->string('title_ar')->nullable();
            $table->text('description_ar')->nullable();
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
        Schema::dropIfExists('program_galleries');
    }
}
