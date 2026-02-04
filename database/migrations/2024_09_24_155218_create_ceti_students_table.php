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
        Schema::create('ceti_students', function (Blueprint $table) {
            $table->id('ceti_student_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->string('register')->unique();
            $table->string('name');
            $table->string('institutional_mail')->unique();
            $table->string('major');
            $table->string('campus');
            $table->string('education_level');
            $table->string('group');
            $table->string('level');
            $table->string('shift');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ceti_students');
    }
};
