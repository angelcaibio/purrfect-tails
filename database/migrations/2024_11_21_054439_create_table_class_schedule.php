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
        Schema::create('class_schedule', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedid');
            $table->foreign('schedid')->nullable()->references('schedid')->on('table_subjects');
            $table->unsignedBigInteger('facultyid');
            $table->foreign('facultyid')->nullable()->references('id')->on('users');
            $table->string('day');
            $table->string('time');
            $table->string('room');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_schedule');
    }
};
