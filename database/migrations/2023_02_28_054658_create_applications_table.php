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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('posisi');
            $table->string('posisialt')->nullable();
            $table->string('undangan')->nullable();
            $table->string('info')->nullable();
            $table->string('kerabat')->nullable();
            $table->string('jadwalinterview')->nullable();
            $table->string('hasil')->nullable();
            $table->string('jadwalgabung')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
