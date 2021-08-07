<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZonessDispenserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zoness_dispenser', function (Blueprint $table) {
            $table->id();
            $table->integer('station_id')->default('0');
            $table->string('Dis_no')->nullable();
            $table->string('Brand')->nullable();
            $table->string('Port_OS')->nullable();
            $table->string('comport_no')->nullable();
            $table->string('Fuel_type')->nullable();
            $table->string('Dis_type')->nullable();
            $table->integer('Hoseno')->default('0');
            $table->string('Flow_rate')->nullable();
            $table->string('Meter_R1_no')->nullable();
            $table->string('Meter_L1_no')->nullable();
            $table->string('Meter_R2_no')->nullable();
            $table->string('Meter_L2_no')->nullable();
            $table->string('Meter_type')->nullable();
            $table->string('Totalizer_type')->nullable();
            $table->string('Totalizer_R1_no')->nullable();
            $table->string('Totalizer_L1_no')->nullable();
            $table->string('Totalizer_R2_no')->nullable();
            $table->string('Totalizer_L2_no')->nullable();

  $table->string('Electric_Board_no')->nullable();
  $table->string('screen_no')->nullable();
  $table->string('Pulser_R1_no')->nullable();
  $table->string('Pulser_L1_no')->nullable();
  $table->string('Pulser_R2_no')->nullable();
  $table->string('Pulser_L2_no')->nullable();
  $table->string('sensorswitch_R1')->nullable();
  $table->string('sensorswitch_L1')->nullable();
  $table->string('sensorswitch_R2')->nullable();
  $table->string('sensorswitch_L2')->nullable();
 

 $table->string('Motor_no')->nullable();
 $table->string('Motor_HP')->nullable();
 $table->string('Motor_belt_size')->nullable();
 $table->string('Pump_R1_no')->nullable();
 $table->string('Pump_L1_no')->nullable();
 $table->string('Pump_R2_no')->nullable();
 $table->string('Pump_L2_no')->nullable();
 
 $table->string('Centrifugalpump1')->nullable();
 $table->string('Centrifugalpump2')->nullable();
 $table->string('Centrifugalpump3')->nullable();
 $table->string('Centrifugalpump4')->nullable();
 

 $table->string('Deliverymeter1')->nullable();
 $table->string('Deliverymeter1Type')->nullable();
 $table->string('Deliverymeter2')->nullable();
 $table->string('Deliverymeter2Type')->nullable();
 $table->string('Deliverymeter3')->nullable();
 $table->string('Deliverymeter3Type')->nullable();
 $table->string('Deliverymeter4')->nullable();
 $table->string('Deliverymeter4Type')->nullable();
 $table->string('manufacture_dt')->nullable();
 $table->string('Instalation_date')->nullable();

            
            $table->integer('LocCriticality')->default('0');
            $table->integer('AreaId')->default('0'); 
            $table->integer('CompanyID')->default('0');
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
        Schema::dropIfExists('zoness_dispenser');
    }
}
