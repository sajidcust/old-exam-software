<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsFeesSelections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students_fees_selections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('students_fees_id');
            $table->foreign('students_fees_id')->references('id')->on('students_fees');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students');
            $table->unsignedBigInteger('semester_id');
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->unsignedBigInteger('fee_id');
            $table->foreign('fee_id')->references('id')->on('fees');
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
        Schema::dropIfExists('students_fees_selections');
    }
}
