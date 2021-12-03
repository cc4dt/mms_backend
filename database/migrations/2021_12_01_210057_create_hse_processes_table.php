<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHseProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hse_processes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hse_id')->constrained()->onDelete('cascade');
            $table->foreignId('station_id')->constrained()->onDelete('cascade');
            $table->foreignId('master_equipment_id')->nullable()->constrained('master_equipment')->onDelete('cascade');
            $table->timestamp('timestamp');
            $table->foreignId('created_by_id')->constrained("users")->onDelete('cascade');
            $table->foreignId('updated_by_id')->constrained("users")->onDelete('cascade');
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
        Schema::dropIfExists('hse_processes');
    }
}
