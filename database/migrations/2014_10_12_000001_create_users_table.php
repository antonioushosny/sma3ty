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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable($value = true);
            $table->string('email')->nullable($value = true);
            $table->string('password')->nullable($value = true);
            $table->string('mobile')->nullable($value = true);
            $table->string('image')->nullable($value = true);
            $table->string('device_token')->nullable($value = true);
            $table->enum('role', ['admin','doctor','user']);    
            $table->string('status');        
            $table->tinyInteger('type')->nullable($value = true); 
            $table->softDeletes();      
            $table->string('lang')->nullable($value = 'ar'); 
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
        Schema::dropIfExists('users');
    }
}
