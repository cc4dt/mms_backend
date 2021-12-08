<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
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
            $table->string('username')->unique()->nullable();
            $table->string('device_token')->nullable();
            $table->integer('positions')->default('0');
            $table->integer('department_no')->default('0');
            $table->integer('extension')->default('0');
            $table->integer('hide_cost')->default('-1');
            $table->string('work_phone')->nullable();
            $table->integer('level_id')->default('5');
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('created_by_id')->nullable()->constrained("users")->onDelete('cascade');
            $table->foreignId('updated_by_id')->nullable()->constrained("users")->onDelete('cascade');
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
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