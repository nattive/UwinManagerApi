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
            $table->string('business_unit')->nullable();
            $table->string('isHOM')->default(0);
            $table->string('duty')->default('manager');
            $table->string('isActive')->default(1);
            $table->string('email')->unique();
            $table->string('head_of_manager_id')->nullable();
            $table->string('location')->nullable();
            $table->string('phoneNumber')->nullable();
            $table->string('guarantorPhone')->nullable();
            $table->string('guarantorAddress')->nullable();
            $table->string('profile_image')->nullable();
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
