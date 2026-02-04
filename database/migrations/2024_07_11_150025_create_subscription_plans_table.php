<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id('plan_id');
            $table->string('plan_token', 32);
            $table->string('name', 50);
            $table->string('role_name');
            $table->foreign('role_name')->references('role_name')->on('user_roles');
            $table->decimal('price', 8, 2);
            $table->string('currency', 10);
            $table->enum('frequency', ['monthly', 'yearly', null])->nullable();
            $table->text('description')->nullable();
            $table->json('benefits');
            $table->enum('status', ['active', 'inactive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
