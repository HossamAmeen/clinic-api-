<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city_tb', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ar_title');
            $table->string('en_title',30)->nullable();
            $table->boolean('is_default')->default(0);

            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('country_tb')->onDelete('cascade')->onUpdate('cascade');
            
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
        Schema::dropIfExists('city_tb');
    }
}
