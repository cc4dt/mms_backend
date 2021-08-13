<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            //Fill By Client
            $table->foreignId('station_id')->constrained()->onDelete('cascade')->nullable();
            $table->foreignId('breakdown_id')->constrained()->onDelete('cascade')->nullable();
            $table->text('open_description')->nullable();
            //Fill By Supervisor
            $table->foreignId('teamleader_id')->constrained("users")->onDelete('cascade')->nullable();
            $table->integer("type_id")->nullable();
            $table->integer('trade_id')->nullable();
            $table->integer('priority_id')->nullable();
            $table->text('work_description')->nullable();

            $table->integer('status_id')->constrained("ticket_status")->nullable();
            $table->foreignId('created_by_id')->constrained("users")->onDelete('cascade')->nullable();
            $table->foreignId('updated_by_id')->constrained("users")->onDelete('cascade')->nullable();
            $table->timestamps();

            // $table->foreign('created_by')
            //     ->references('id')
            //     ->on('users')
            //     ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}