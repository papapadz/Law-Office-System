<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queries', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_number')->nullable();
            $table->foreignId('client_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('lawyer_id')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('declined_id')->nullable();
            $table->string('category')->nullable();
            $table->string('question')->nullable();
            $table->string('subject')->nullable();
            $table->string('resolution_type')->nullable();
            $table->string('status')->nullable();            
            $table->string('proof_photo_url')->nullable();
            $table->boolean('is_payment_verified')->default(0);
            $table->string('attached_file')->nullable();
            $table->string('reply_to_written_resolution')->nullable();
            $table->string('reply_offline')->nullable();
            $table->string('summary_from_lawyer')->nullable();
            $table->date('available_date_1')->nullable();
            $table->string('available_time_1')->nullable();
            $table->date('available_date_2')->nullable();
            $table->string('available_time_2')->nullable();
            $table->date('available_date_3')->nullable();
            $table->string('available_time_3')->nullable();
            $table->date('schedule_date')->nullable();
            $table->string('schedule_time')->nullable();
            $table->date('assigned_date')->nullable();
            $table->string('assigned_time')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('queries');
    }
}
