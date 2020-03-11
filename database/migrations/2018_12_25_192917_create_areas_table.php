<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable($value = true);
            $table->string('image')->nullable($value = true);
            $table->enum('status', ['1','0'])->default('1');
            $table->unsignedBigInteger('city_id')->nullable($value = true);
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade'); 
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
        Schema::dropIfExists('areas');
    }
}
