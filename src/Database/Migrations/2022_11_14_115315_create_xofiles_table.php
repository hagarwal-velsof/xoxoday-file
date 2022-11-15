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
        Schema::create('xofiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('xouser_id');
            $table->string('response_no')->unique();
            $table->string('file_name')->nullable();
            $table->string('path')->nullable();
            $table->string('otp',10)->nullable(); 
            $table->tinyInteger('status'); // 1 means OTP verified, 0 means pending
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
        Schema::dropIfExists('xofiles');
    }
};
