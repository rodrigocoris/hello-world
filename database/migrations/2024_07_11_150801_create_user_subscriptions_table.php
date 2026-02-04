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
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id('subscription_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->unsignedBigInteger('plan_id');
            $table->foreign('plan_id')->references('plan_id')->on('subscription_plans');
            
            // Paypal spesific information
            $table->string('paypal_subscription_id')->unique();
            $table->string('paypal_plan_id');
            $table->string('status');
            $table->string('status_update_time');
            
            // Start and finish date
            $table->string('start_at');
            $table->string('finish_at')->nullable();
            $table->string('end_at')->nullable();
            
            // Pay information
            $table->decimal('last_payment_amount', 10, 2)->nullable();
            $table->string('last_payment_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
};
