<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->string('board_full_name');
            $table->string('minister_name');
            $table->string('minister_image');
            $table->longText('ministers_message');
            $table->string('secretary_name');
            $table->string('secretary_image');
            $table->longText('secretarys_message');
            $table->string('controller_name');
            $table->string('controller_image');
            $table->longText('controllers_message');
            $table->string('controller_signature');
            $table->string('deputy_controller_name');
            $table->string('deputy_controller_signature');
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
        Schema::dropIfExists('settings');
    }
}
