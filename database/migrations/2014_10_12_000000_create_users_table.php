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
    { Schema::create('users', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('full_name');
        $table->string('image')->nullable();
        $table->integer('age')->nullable();
        $table->string('email')->unique();
        $table->integer('phone_number')->unique();
        $table->timestamp('email_verified_at')->nullable();//it is not important we got nulls in database
        $table->string('password');
        $table->boolean('is_expert');
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
};

