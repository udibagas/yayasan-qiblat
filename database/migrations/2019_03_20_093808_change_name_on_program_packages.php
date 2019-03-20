<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNameOnProgramPackages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('program_packages', function (Blueprint $table) {
            $table->renameColumn('name', 'name_id');
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
        Schema::table('program_packages', function (Blueprint $table) {
            $table->renameColumn('name_id', 'name');
            $table->renameColumn('description_id', 'description');
        });
    }
}
