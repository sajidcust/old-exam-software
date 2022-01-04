<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institutions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->boolean('is_ddo');
            $table->unsignedBigInteger('ddo_id')->nullable();
            $table->foreign('ddo_id')->references('id')->on('institutions');
            $table->boolean('is_center');
            $table->unsignedBigInteger('tehsil_id');
            $table->foreign('tehsil_id')->references('id')->on('tehsils');
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
        Schema::dropIfExists('institutions');
    }
}
