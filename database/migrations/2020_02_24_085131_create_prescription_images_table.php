<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescriptionImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescription_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->integer('visit_id')->unsigned()->nullable();
            $table->foreign('visit_id')->references('id')->on('patient_visit_tb')->onUpdate('cascade');

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
        Schema::dropIfExists('prescription_images');
    }
}
