<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceProceduresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_procedures', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar');
            $table->integer('type_id');
            $table->foreignId('input_type_id')->default(1)->constrained('enums')->onDelete('cascade');
            $table->integer('sequence')->default(1);
            $table->integer('cat_id')->default(1);
            $table->foreignId('spare_part_id')->nullable()->constrained('spare_parts')->onDelete('cascade');
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
        Schema::dropIfExists('maintenance_procedures');
    }
}
