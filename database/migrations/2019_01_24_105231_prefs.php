<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Prefs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prefs_tb', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',30);
            $table->string('email',60)->nullable();
            $table->string('description',120)->nullable();
            $table->string('facebook',120)->url()->nullable();
            $table->string('address')->nullable();
            $table->string('sales_tel')->nullable();
            $table->string('call_center')->nullable();
            $table->string('zedy_web_site',60)->url()->nullable();
            $table->string('whatsapp',25)->nullable();

            $table->string('android_download_link',120)->url()->nullable();


            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users_tb')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('prefs_tb');
    }
}
