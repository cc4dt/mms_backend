<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePmDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pm_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('process_id')->constrained("pm_processes")->onDelete('cascade');
            $table->foreignId('spare_part_id')->nullable()->constrained('spare_sub_parts')->onDelete('cascade');
            $table->foreignId('procedure_id')->constrained("maintenance_procedures")->onDelete('cascade');
            $table->foreignId('option_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('value')->nullable();
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
        Schema::dropIfExists('pm_details');
    }
}
