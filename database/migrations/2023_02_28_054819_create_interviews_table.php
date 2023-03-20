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
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->string('application_id');
            $table->text('interview_hr')->nullable();
            $table->text('interview_user')->nullable();
            $table->text('interview_manajemen')->nullable();
            $table->string('nama_hr')->nullable();
            $table->string('nama_user')->nullable();
            $table->string('nama_manajemen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};
