<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuelConsumptionReportsTable extends Migration
{
    /**
     * 
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuel_consumption_reports', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('date_finished')->nullable();
            $table->string('date_supplied')->nullable();
            $table->string('usage_duration');
            $table->string('volume');
            $table->string('petrol_station')->nullable();
            $table->string('isApprovedBy')->nullable();
            $table->string('hasReceived')->nullable();
            // $table->string('needApproval')->nullable();
            $table->string('orderInterval')->nullable();
            $table->integer('pricePerLitre')->default(0);
            $table->integer('requestThisMonth')->default(0);
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
        Schema::dropIfExists('fuel_consumption_reports');
    }
}
