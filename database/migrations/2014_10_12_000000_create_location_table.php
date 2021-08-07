<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location', function (Blueprint $table) {
            $table->id();
            $table->string('LocationDescription')->nullable();
            $table->string('LocationDescription_ar')->nullable();
            $table->string('NotetoTech')->nullable();
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
        Schema::dropIfExists('location');
    }
}
