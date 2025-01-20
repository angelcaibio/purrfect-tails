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
        Schema::create('table_registration', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('semid');
            $table->foreign(columns: 'semid')->nullable()->reference('id')->on('table_semester');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_registration');
    }
};
