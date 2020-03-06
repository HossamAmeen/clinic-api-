<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_tb', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('user_name');
            $table->string('temp_user_name',60)->nullable();
            $table->string('temp_password',120)->nullable();
            $table->string('email',45)->unique();
            $table->string('img',60)->nullable();
            $table->string('password');
            $table->integer('role');
            $table->boolean('active')->default(1);
            $table->integer('user_id')->unsigned()->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users_tb');
    }
}
