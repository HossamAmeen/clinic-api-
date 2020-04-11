<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClinicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_tb', function (Blueprint $table) {
            $table->increments('id');
            $table->string('clinic_name',60);
            $table->string('clinic_tel',20)->nullable();
            $table->string('facebook',60)->nullable();
            $table->integer('no_of_patients')->default(0);
            $table->integer('patient_waiting_time_in_minutes')->default(30);
            $table->string('mac_address',25);
            $table->boolean('in_clinic_now')->default(0);

//            $table->string('__TOKEN',120);

            $table->integer('client_id')->unsigned()->nullable();
            $table->foreign('client_id')->references('id')->on('client_tb')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users_tb')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('clinic_tb');
    }
}
