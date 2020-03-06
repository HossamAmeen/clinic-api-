<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTownTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('town_tb', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ar_title');
            $table->string('en_title',30)->nullable();
            $table->boolean('is_default')->default(0);

            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('city_tb')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('town_tb');
    }
}
