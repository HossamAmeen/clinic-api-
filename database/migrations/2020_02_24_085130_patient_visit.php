<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PatientVisit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_visit_tb', function (Blueprint $table) {
            $table->increments('id');

            $table->string('initial_diagnose',120);
            $table->string('prescription_image',60)->nullable();
            $table->string('notes',512)->nullable();
            $table->date('consultation_date')->nullable();

            $table->dateTime('visit_datetime');

            $table->integer('client_id')->unsigned()->nullable();
            $table->foreign('client_id')->references('id')->on('client_tb')->onUpdate('cascade');

            $table->integer('patient_id')->unsigned()->nullable();
            $table->foreign('patient_id')->references('id')->on('patient_tb')->onUpdate('cascade');

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users_tb')->onUpdate('cascade');

            $table->integer('client_visit_id')->unsigned()->nullable();
            
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
}//end patient visit
