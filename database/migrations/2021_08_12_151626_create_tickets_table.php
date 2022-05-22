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
            $table->boolean('client_side');
            
            //Fill By Client
            $table->foreignId('state_id')->constrained()->onDelete('cascade');
            $table->foreignId('station_id')->constrained()->onDelete('cascade');
            $table->foreignId('equipment_id')->constrained()->onDelete('cascade');
            $table->foreignId('breakdown_id')->constrained()->onDelete('cascade');
            $table->text('open_description')->nullable();
            //Fill By Supervisor
            $table->foreignId('teamleader_id')->nullable()->constrained("users")->onDelete('cascade');
            $table->foreignId('type_id')->nullable()->constrained("ticket_types")->onDelete('cascade');
            $table->foreignId('trade_id')->nullable()->constrained("ticket_trades")->onDelete('cascade');
            $table->foreignId('priority_id')->nullable()->constrained("ticket_priorities")->onDelete('cascade');
            $table->text('work_description')->nullable();

            $table->foreignId('status_id')->constrained("ticket_statuses")->onDelete('cascade');

            $table->foreignId('created_by_id')->nullable()->constrained("users")->onDelete('cascade');
            $table->foreignId('updated_by_id')->nullable()->constrained("users")->onDelete('cascade');
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
        Schema::dropIfExists('tickets');
    }
}