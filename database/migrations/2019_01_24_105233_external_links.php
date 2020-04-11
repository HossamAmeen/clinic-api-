<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExternalLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_links_tb', function (Blueprint $table) {
            $table->increments('id');
            $table->string('zedy_url',60)->nullable();
            $table->string('whatsapp_url',60)->nullable();
            $table->string('site_url',60)->nullable();
            $table->string('u_clinics_facebook_url',60)->nullable();
            $table->string('social_media_services_url',60)->nullable();
            $table->string('branding_services_url',60)->nullable();
            $table->string('video_services_url',60)->nullable();
            $table->string('sites_services_url',60)->nullable();
            $table->string('mobile_services_url',60)->nullable();
            $table->string('printing_services_url',60)->nullable();
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
        Schema::dropIfExists('external_links_tb');
    }

}
