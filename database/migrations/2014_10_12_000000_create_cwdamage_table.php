<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCwdamageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cwdamage', function (Blueprint $table) {
            $table->id();
            $table->string('DamageCode')->nullable();
            $table->string('DamageCode_ar')->nullable();
            $table->string('Damage')->nullable();
            $table->integer('damge_equip_id')->default(0);
            $table->integer('classid')->default(0);
            $table->string('cwdamagecol')->nullable();
            $table->string('No')->nullable();
            $table->integer('JobID')->default('0');
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
        Schema::dropIfExists('cwdamage');
    }
}
