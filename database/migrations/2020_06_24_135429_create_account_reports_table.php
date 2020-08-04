<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('unsettledWinnings')->default(0);
            $table->integer('totalPayout')->default(0);
            $table->integer('actualCashAtHand')->default(0);
            $table->integer('sub_total1')->default(0);
            $table->integer('totalRunCred')->default(0);
            $table->integer('eCreditFunded')->default(0);
            $table->integer('cashFunded')->default(0);
            $table->integer('creditUnpaidTotal')->default(0);
            $table->integer('expenseTotal')->default(0);
            $table->integer('onlineBalance')->default(0);
            $table->integer('expectedCashAtHand')->default(0);
            $table->integer('sub_total2')->default(0);
            $table->integer('fuel')->default(0);
            $table->integer('misc')->default(0);
            $table->string('isApprovedBy')->nullable();
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
        Schema::dropIfExists('account_reports');
    }
}
