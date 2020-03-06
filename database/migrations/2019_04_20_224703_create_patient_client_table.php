<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_client_tb', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_pk_value')->unsigned()->nullable();
            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('client_tb');
            $table->integer('patient_id')->unsigned();
            $table->foreign('patient_id')->references('id')->on('patient_tb');
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
        Schema::dropIfExists('patient_client_tb');
    }
}
