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
            $table->string('user_number')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('date_of_last_query')->nullable();
            $table->bigInteger('totalAssigned')->default(0);
            $table->string('password');
            $table->rememberToken();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->string('proof_photo_path', 2048)->nullable();
            $table->string('roll_number')->nullable();
            $table->string('specialization')->nullable();
            $table->string('availability')->nullable();
            $table->string('location')->nullable();
            $table->timestamps();
            $table->boolean('is_verified')->default(0);
            $table->string('verification_code')->nullable();
            $table->foreignId('role_id')->default(1)->constrained('roles')->onDelete('cascade');
            $table->dateTime('last_login')->nullable();
            $table->softDeletes();
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
