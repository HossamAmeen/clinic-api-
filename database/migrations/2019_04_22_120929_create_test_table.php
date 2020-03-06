<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_tb', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',120);
            $table->boolean('is_stable')->default(0);
            $table->boolean('is_verified')->default(0);
            $table->integer('client_pk_value')->unsigned()->nullable();
            $table->integer('client_id')->unsigned();
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
        Schema::dropIfExists('test_tb');
    }
}
