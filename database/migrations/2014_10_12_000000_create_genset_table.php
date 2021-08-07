<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGensetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genset', function (Blueprint $table) {
            $table->id();
            $table->string('serial_no')->nullable();
            $table->string('gen_timer')->nullable();
            $table->string('gen_oillevel')->nullable();
            $table->string('gen_ladaterwater')->nullable();
            $table->string('gen_outletstatus')->nullable();
            $table->string('gen_outletstem')->nullable();
            $table->string('gen_battryreading')->nullable();
            $table->string('gen_battrylevel')->nullable(); 
            
             $table->string('gen_airfiltter')->nullable(); 
             $table->string('gen_emergemcey key')->nullable(); 
              $table->string('gen_station')->nullable(); 
             $table->string('gen_month')->nullable(); 
             $table->string('gen_date')->nullable(); 
             $table->string('gen_employee_id')->nullable(); 
             $table->string('gen_year')->nullable(); 
             $table->string('gen_note')->nullable(); 
             $table->string('gen_box')->nullable(); 
             $table->string('PmID')->nullable(); 
           
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
        Schema::dropIfExists('genset');
    }
}
