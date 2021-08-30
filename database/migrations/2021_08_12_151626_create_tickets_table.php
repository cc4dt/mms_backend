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
            $table->foreignId('station_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('breakdown_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('open_description')->nullable();
            //Fill By Supervisor
            $table->foreignId('teamleader_id')->nullable()->constrained("users")->onDelete('cascade');
            $table->integer("type_id")->nullable();
            $table->integer('trade_id')->nullable();
            $table->integer('priority_id')->nullable();
            $table->text('work_description')->nullable();

            $table->integer('status_id')->constrained("ticket_status")->nullable();
            $table->foreignId('created_by_id')->nullable()->constrained("users")->onDelete('cascade');
            $table->foreignId('updated_by_id')->nullable()->constrained("users")->onDelete('cascade');
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