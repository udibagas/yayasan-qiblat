<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Setting;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('label');
            $table->string('type', 15);
            $table->string('description')->nullable();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        $settings = [
            [
                'name' => 'name',
                'label' => 'Name',
                'type' => 'text',
                'description' => 'Nama Website',
                'value' => 'Yasayan Qiblat'
            ],
            [
                'name' => 'description',
                'label' => 'Description',
                'type' => 'textarea',
                'description' => 'Deskripsi singkat website',
                'value' => ''
            ],
            [
                'name' => 'contact_phone',
                'label' => 'Contact Phone',
                'type' => 'text',
                'description' => 'Nomor HP yang bisa dihubungi oleh pengunjung',
                'value' => ''
            ],
            [
                'name' => 'contact_email',
                'label' => 'Email Address',
                'type' => 'text',
                'description' => 'Alamat email untuk surat menyurat',
                'value' => ''
            ],
            [
                'name' => 'contact_address',
                'label' => 'Address',
                'type' => 'textarea',
                'description' => 'Alamat kantor untuk surat menyurat',
                'value' => ''
            ],
            [
                'name' => 'maps_scr',
                'label' => 'Maps URL',
                'type' => 'textarea',
                'description' => 'URL Goole Maps',
                'value' => ''
            ],
        ];

        Setting::insert($settings);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
