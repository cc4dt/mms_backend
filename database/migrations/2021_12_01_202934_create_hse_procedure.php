<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHseProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hse_procedure', function (Blueprint $table) {
            $table->foreignId('hse_id')->constrained()->onDelete('cascade');
            $table->foreignId('procedure_id')->constrained("maintenance_procedures")->onDelete('cascade');
            
            $table->primary(['hse_id', 'procedure_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hse_procedure');
    }
}
