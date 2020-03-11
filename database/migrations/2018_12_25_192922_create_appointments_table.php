<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('day')->nullable($value = true);
            $table->string('from')->nullable($value = true);
            $table->string('to')->nullable($value = true);
            $table->enum('status', ['active', 'not_active'])->default('active');
            $table->unsignedBigInteger('doctor_id')->nullable($value = true);
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade'); 
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
        Schema::dropIfExists('appointments');
    }
}
