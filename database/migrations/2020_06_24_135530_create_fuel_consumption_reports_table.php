<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuelConsumptionReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuel_consumption_reports', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->integer('user_id')->unsigned();
            $table->string('work_attendance');
            $table->string('punctuality');
            $table->string('accountability');
            $table->string('cr_rs');
            $table->string('revenue_per_day');
            $table->string('appearance');
            $table->string('general_equipment_maintenance');
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
