<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('username')->nullable();
            $table->integer('Positions')->default('0');
            $table->integer('DepartmentNo')->default('0');
            $table->integer('Extension')->default('0');
            $table->integer('HideCost')->default('-1');
            $table->string('WorkPhone')->nullable();
            $table->integer('level')->default('0');
            $table->string('DeviceToken')->nullable();
            $table->integer('CompanyID')->default('1'); 
            $table->string('create_by')->nullable();
            $table->string('update_by')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
