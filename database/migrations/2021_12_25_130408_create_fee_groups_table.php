<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fee_group_name');
            $table->unsignedBigInteger('class_id');
            $table->foreign('class_id')->references('id')->on('standards');
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
        Schema::dropIfExists('fee_groups');
    }
}
