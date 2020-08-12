<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->string('isHOM')->default(0);
            $table->string('isActive')->default(1);
            $table->string('email')->unique();
            $table->string('head_of_manager_id')->nullable();
            $table->string('location')->nullable();
            $table->string('phoneNumber')->nullable();
            $table->string('guarantorPhone')->nullable();
            $table->string('guarantorAddress')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->string('url')->nullable();
            $table->boolean('isOnline')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
