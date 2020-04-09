<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_tb', function (Blueprint $table) {
            $table->increments('id');
            $table->string('clinic_name',60);
            $table->string('clinic_email',60);//not unique
            $table->string('doctor_tel',20);
            $table->integer('no_of_patients');
            $table->string('mac_address',25);
            $table->string('doctor_full_name',120);
            $table->boolean('in_clinic_now')->default(0);
            $table->string('__TOKEN',120);
            $table->string('qualifications',1024);
            $table->integer('specialist_id')->unsigned()->nullable();
            $table->foreign('specialist_id')->references('id')->on('specialist_tb')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('town_id')->unsigned()->nullable();
            $table->foreign('town_id')->references('id')->on('town_tb')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('city_id')->unsigned()->nullable();
            $table->foreign('city_id')->references('id')->on('city_tb')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('country_id')->unsigned()->nullable();
            $table->foreign('country_id')->references('id')->on('country_tb')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users_tb')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('client_user_id')->unsigned();
            $table->foreign('client_user_id')->references('id')->on('users_tb')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('client_tb');
    }
}
