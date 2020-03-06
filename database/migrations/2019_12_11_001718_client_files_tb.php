<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClientFilesTb extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_file_tb', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',120);
            $table->double('size')->nullable();
            $table->string('extension')->nullable();
            $table->integer('client_file_id')->unsigned();
            $table->string('url');

            $table->integer('client_id')->unsigned()->nullable();
            $table->foreign('client_id')->references('id')->on('client_tb')->onUpdate('cascade');
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
        Schema::dropIfExists('client_file_tb');
    }
}
