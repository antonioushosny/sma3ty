<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('clinic')->nullable($value = true);
            $table->string('address')->nullable($value = true);
            $table->text('desc')->nullable($value = true);
            $table->enum('status', ['active', 'not_active'])->default('active');
            $table->unsignedBigInteger('country_id')->nullable($value = true);
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade'); 
            $table->unsignedBigInteger('city_id')->nullable($value = true);
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade'); 
            $table->unsignedBigInteger('area_id')->nullable($value = true);
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade'); 
            $table->unsignedBigInteger('specialties_id')->nullable($value = true);
            $table->foreign('specialties_id')->references('id')->on('specialties')->onDelete('cascade'); 
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
        Schema::dropIfExists('doctor_details');
    }
}
