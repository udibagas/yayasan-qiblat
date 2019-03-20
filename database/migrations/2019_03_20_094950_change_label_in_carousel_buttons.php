<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeLabelInCarouselButtons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carousel_buttons', function (Blueprint $table) {
            $table->renameColumn('label', 'label_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carousel_buttons', function (Blueprint $table) {
            $table->renameColumn('label_id', 'label');
        });
    }
}
