<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('message_id');
            $table->integer('number');
            $table->text('api_response');
            $table->timestamp('send_time')->nullable();
            $table->foreign('message_id')->references('id')->on('messages');
        });    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
