<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNameOnPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('title', 'title_id');
            $table->renameColumn('content', 'content_id');
            $table->renameColumn('slug', 'slug_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('title_id', 'title');
            $table->renameColumn('content_id', 'content');
            $table->renameColumn('slug_id', 'slug');
        });
    }
}
