<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWSKPASTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_s_k_p_a_s', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('full_name');
            $table->string('work_attendance');
            $table->string('punctuality');
            $table->string('accountability');
            $table->string('cr_rs');
            $table->string('revenue_per_day');
            $table->string('appearance');
            $table->string('workPercentage');
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
        Schema::dropIfExists('w_s_k_p_a_s');
    }
}
