<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCloseTicketTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('close_ticket', function (Blueprint $table) {
            $table->id();
            $table->integer('WorkorderNo');
            $table->integer('equ_id');
            $table->integer('PartID');
            $table->integer('PID');
            $table->integer('MaintainID');
            $table->string('Discription')->nullable();
            $table->timestamps();
            $table->string('create_by')->nullable();
            $table->string('update_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('close_ticket');
    }
}
