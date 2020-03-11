<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('chat_id')->nullable($value = true);
            $table->foreign('chat_id')->references('id')->on('chats')->onDelete('cascade'); 
            $table->unsignedBigInteger('sender_id')->nullable($value = true);
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->unsignedBigInteger('recipient_id')->nullable($value = true);
            $table->foreign('recipient_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('text')->nullable($value = true);
            $table->string('status')->default('new');
            $table->string('type')->default('');
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
        Schema::dropIfExists('messages');
    }
}
