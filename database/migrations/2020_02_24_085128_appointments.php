<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Appointments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments_tb', function (Blueprint $table) {
            $table->increments('id');

            $table->date('date');
            $table->time('from_time');
            $table->time('to_time');
            $table->boolean('is_online_reservation')->default(0);

            $table->integer('visit_type_id')->unsigned()->nullable();
            $table->foreign('visit_type_id')->references('id')->on('visit_type_tb')->onUpdate('cascade');

            $table->integer('patient_id')->unsigned()->nullable();
            $table->foreign('patient_id')->references('id')->on('patient_tb')->onUpdate('cascade');

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users_tb')->onUpdate('cascade');
            $table->integer('clinic_id')->unsigned()->nullable();
            $table->foreign('clinic_id')->references('id')->on('clinic_tb')->onUpdate('cascade');
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('appointments_tb');
    }
}//end appointments
