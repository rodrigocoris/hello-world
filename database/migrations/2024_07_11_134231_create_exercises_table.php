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
        Schema::create('exercises', function (Blueprint $table) {
            $table->id('exercise_id');
            $table->string('exercise_token')->unique();
            $table->unsignedBigInteger('lesson_id');
            $table->foreign('lesson_id')->references('lesson_id')->on('lessons');
            $table->string('exercise', 100);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('difficulty_id');
            $table->foreign('difficulty_id')->references('difficulty_id')->on('difficulties');
            $table->integer('hierarchy');
            $table->text('body_code');
            $table->json('test_cases')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
