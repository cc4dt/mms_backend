<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkTypeTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('worktype', function (Blueprint $table) {
            $table->id();
            $table->string('WorkTypeDescription')->nullable();
            $table->string('WorkTypeDescription_ar')->nullable();
            $table->timestamps();
            $table->string('create_by')->nullable();
            $table->string('update_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('worktype');
    }
}
