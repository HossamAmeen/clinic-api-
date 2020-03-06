<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackUpFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('back_up_files_tb', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('no_of_using')->unsigned()->default(0);
            $table->string('url',120);
            $table->integer('backup_licence_id')->unsigned();
            $table->foreign('backup_licence_id')->references('id')->on('backup_licence_tb');
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
        Schema::dropIfExists('back_up_files_tb');
    }
}
