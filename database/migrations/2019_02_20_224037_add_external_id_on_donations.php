<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExternalIdOnDonations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->string('external_id')->nullable();
            $table->string('merchant_name')->nullable();
            $table->integer('billable_amount', false, true)->nullable();
            $table->integer('received_amount', false, true)->nullable();
            $table->integer('xendit_fee_amount', false, true)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn([
                'external_id', 
                'merchant_name', 
                'billable_amount', 
                'received_amount',
                'xendit_fee_amount'
            ]);
        });
    }
}
