<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNameOnGalleries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('program_galleries', function (Blueprint $table) {
            $table->renameColumn('title', 'title_id');
            $table->renameColumn('description', 'description_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('program_galleries', function (Blueprint $table) {
            $table->renameColumn('title_id', 'title');
            $table->renameColumn('description_id', 'description');
        });
    }
}
