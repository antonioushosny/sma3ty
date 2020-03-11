<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('date')->nullable($value = true);
            $table->string('from')->nullable($value = true);
            $table->string('to')->nullable($value = true);
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('doctor_id')->nullable($value = true);
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->unsignedBigInteger('user_id')->nullable($value = true);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->unsignedBigInteger('appointments_id')->nullable($value = true);
            $table->foreign('appointments_id')->references('id')->on('appointments')->onDelete('cascade'); 
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
        Schema::dropIfExists('reservations');
    }
}
