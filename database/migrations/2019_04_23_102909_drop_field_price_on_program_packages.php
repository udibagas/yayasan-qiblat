<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropFieldPriceOnProgramPackages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('program_packages', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->boolean('allow_multiple')->default(1);
            $table->integer('multiple_step')->default(1);
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
            $table->decimal('price')->nullable();
            $table->dropColumn(['allow_multiple', 'multiple_step']);
        });
    }
}
