<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notify_users', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('body');
            // $table->integer('user_id');
            $table->integer('from_user_id')->nullable();
            $table->boolean('isRead')->default(false);
            $table->string('type')->default('others'); //chat, others
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
        Schema::dropIfExists('notify_users');
    }
}
