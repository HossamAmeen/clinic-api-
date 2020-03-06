<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_tb', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',120);
            $table->longText('address')->nullable();
            $table->string('tel')->nullable();
            $table->boolean('is_accept_updates')->default(0);
            $table->boolean('is_stable')->default(0);
            $table->integer('client_pk_value')->unsigned()->nullable();
            $table->integer('town_id')->unsigned();
            $table->foreign('town_id')->references('id')->on('town_tb')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('client_id')->unsigned()->nullable();
            $table->foreign('client_id')->references('id')->on('client_tb')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users_tb')->onUpdate('cascade');
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
        Schema::dropIfExists('lab_tb');
    }
}
