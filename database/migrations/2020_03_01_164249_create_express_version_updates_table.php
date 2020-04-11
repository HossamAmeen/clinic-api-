<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpressVersionUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('express_version_updates_tb', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',120);
            $table->string('url',120);
            $table->string('type',60);
            $table->binary('new_queries')->nullable();
            $table->string('version',24)->nullable();
            $table->string('description',512)->nullable();
            $table->string('md5',512)->nullable();
            $table->string('modified_files',120)->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users_tb');
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
        Schema::dropIfExists('express_version_updates_tb');
    }
}
