<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('text');
            $table->boolean('isRead')->default(false);
            $table->unsignedBigInteger('chat_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('receiver_id');
            $table->unsignedBigInteger('group_id')->nullable();
            $table->timestamps();

            $table
                ->foreign('chat_id')
                ->references('id')
                ->on('chats');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_messages');
    }
}
