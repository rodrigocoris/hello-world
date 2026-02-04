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
        Schema::create('compilation_requests', function (Blueprint $table) {
            $table->id('compilation_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->string('compilation_token', 64);
            $table->string('language');
            $table->foreign('language')->references('language')->on('languages');
            $table->text('source_code');
            $table->enum('status', ['queued', 'running', 'completed', 'failed'])->default('queued');
            $table->text('output')->nullable();
            $table->integer('execution_time_ms')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
            $table->index(['language', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compilation_requests');
    }
};
