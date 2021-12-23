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
            $table->foreignId('master_hse_id')->constrained('master_hses')->onDelete('cascade');
            $table->foreignId('hse_id')->constrained()->onDelete('cascade');
            $table->foreignId('equipment_id')->nullable()->constrained('master_equipment')->onDelete('cascade');
            $table->text('description')->nullable();
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
