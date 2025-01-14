<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbilityRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ability_role', function (Blueprint $table) {
            $table->primary(['role_id', 'ability_id']);

            $table->foreignId('role_id');
            $table->foreignId('ability_id');
            $table->timestamps();

            $table->foreign('role_id')
            ->references('id')
            ->on('master_roles')
            ->onDelete('cascade');

            $table->foreign('ability_id')
            ->references('id')
            ->on('abilities')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ability_role');
    }
}
