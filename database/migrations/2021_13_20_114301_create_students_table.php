<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('father_name');
            $table->date('date_of_birth')->default(date("2000-12-12"));
            $table->string('dob_in_words');
            $table->boolean('gender')->default(0);
            $table->text('home_address')->nullable();
            $table->string('cell_no')->nullable();
            $table->string('email')->nullable();
            $table->string('image')->nullable();
            $table->boolean('student_type');
            $table->unsignedBigInteger('class_id');
            $table->foreign('class_id')->references('id')->on('standards');
            $table->unsignedBigInteger('session_id');
            $table->foreign('session_id')->references('id')->on('sessions');
            $table->unsignedBigInteger('institution_id');
            $table->foreign('institution_id')->references('id')->on('institutions');
            $table->unsignedBigInteger('center_id');
            $table->foreign('center_id')->references('id')->on('institutions');
            /*$table->unsignedBigInteger('bank_id');
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->integer('challan_no');
            $table->date('date_of_deposit')->default(date("2000-12-12"));*/
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
        Schema::dropIfExists('students');
    }
}
