<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VisitType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visit_type_tb', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title',40);
            $table->integer('expectation_period_in_minutes');
            $table->boolean('is_favourite')->default(0);
            $table->double('fees');

            $table->integer('clinic_id')->unsigned()->nullable();
            $table->foreign('clinic_id')->references('id')->on('clinic_tb')->onUpdate('cascade');



            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users_tb')->onUpdate('cascade');
            $table->integer('client_visit_type_id')->unsigned()->nullable();
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
        Schema::dropIfExists('patient_visit_tb');
    }
}
