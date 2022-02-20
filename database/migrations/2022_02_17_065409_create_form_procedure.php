<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_procedure', function (Blueprint $table) {
            $table->foreignId('form_id')->constrained('maintenance_forms')->onDelete('cascade');
            $table->foreignId('procedure_id')->constrained("maintenance_procedures")->onDelete('cascade');
            
            $table->primary(['form_id', 'procedure_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_procedure');
    }
}
