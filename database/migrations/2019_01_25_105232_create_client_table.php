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
            $table->string('client_email',60);//not unique
            $table->string('doctor_tel',20);
            $table->string('doctor_full_name',120);
            $table->string('qualifications',1024)->nullable();
            $table->string('__TOKEN',120);
            $table->string('pic',120)->nullable();
             
            $table->boolean('is_available_to_all')->default(1);
            $table->boolean('is_reservation_blocked')->default(0);
            

           
            $table->integer('specialist_id')->unsigned()->nullable();
            $table->foreign('specialist_id')->references('id')->on('specialist_tb')->onDelete('cascade')->onUpdate('cascade');
            $table->string('sub_specialists',256)->nullable();
            $table->integer('town_id')->unsigned()->nullable();
            $table->foreign('town_id')->references('id')->on('town_tb')->onDelete('cascade')->onUpdate('cascade');

            /*$table->integer('city_id')->unsigned()->nullable();
            $table->foreign('city_id')->references('id')->on('city_tb')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('country_id')->unsigned()->nullable();
            $table->foreign('country_id')->references('id')->on('country_tb')->onDelete('cascade')->onUpdate('cascade');*/

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users_tb')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('client_user_id')->unsigned();
            $table->foreign('client_user_id')->references('id')->on('users_tb')->onDelete('cascade')->onUpdate('cascade');

            $table->softDeletes();
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
