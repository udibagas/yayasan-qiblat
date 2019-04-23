<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnPostCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_categories', function (Blueprint $table) {
            $table->renameColumn('name', 'name_id');
            $table->renameColumn('description', 'description_id');
            $table->string('slug_id')->nullable();
            $table->string('slug_en')->nullable();
            $table->string('slug_ar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_categories', function (Blueprint $table) {
            $table->renameColumn('name_id', 'name');
            $table->renameColumn('description_id', 'description');
            $table->dropColumn(['slug_id', 'slug_en', 'slug_ar']);
        });
    }
}
