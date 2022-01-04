<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGazettesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gazettes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('district_id');
            $table->foreign('district_id')->references('id')->on('districts');
            $table->unsignedBigInteger('tehsil_id');
            $table->foreign('tehsil_id')->references('id')->on('tehsils');
            $table->unsignedBigInteger('center_id');
            $table->foreign('center_id')->references('id')->on('institutions');
            $table->unsignedBigInteger('class_id');
            $table->foreign('class_id')->references('id')->on('standards');
            $table->unsignedBigInteger('session_id');
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students');
            $table->unsignedBigInteger('institution_id');
            $table->foreign('institution_id')->references('id')->on('institutions');
            $table->integer('total_max_marks')->default(0);
            $table->integer('total_obt_marks')->default(0);
            $table->double('percentage_marks', 12, 2)->nullable();
            $table->string('grade');
            $table->integer('result');
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
        Schema::dropIfExists('gazettes');
    }
}
