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
            $table->integer('total_running_credit')->default(0);
            $table->integer('eCredit_funded')->default(0);
            $table->integer('unsettled_winnings')->default(0);
            $table->integer('total_payout_winnings')->default(0);
            $table->integer('total_winnings')->default(0);
            $table->integer('paid_out_expenses')->default(0);
            $table->integer('online_balance_at_EOD')->default(0);
            $table->integer('expected_cash_at_hand')->default(0);
            $table->integer('actual_cash_at_hand')->default(0);
            $table->integer('sub_total1')->default(0);
            $table->integer('cash_funded')->default(0);
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
