<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketTimelinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_timelines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->foreignId('status_id')->constrained("ticket_statuses")->onDelete('cascade');
            $table->text('description')->nullable();
            $table->timestamp('timestamp');
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
        Schema::dropIfExists('ticket_timelines');
    }
}
