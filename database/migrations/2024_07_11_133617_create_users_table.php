<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('user_token', 36)->unique();
            $table->string('username', 50);
            $table->string('email', 100)->unique();
            $table->timestamp('verified_at')->nullable();
            $table->string('password')->nullable();
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('role_id')->on('user_roles');
            $table->unsignedBigInteger('organization_id')->nullable();
            $table->foreign('organization_id')->references('organization_id')->on('organizations');
            $table->string('external_id')->nullable();
            $table->string('external_auth')->nullable();
            $table->timestamps();
        });

        Schema::create('user_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->string('token');
            $table->string('extenced_token', 64);
            $table->timestamp('last_sent_at')->nullable();
            $table->enum('type', ['verification', 'recovery', 'elimination']);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_tokens');
    }
};
