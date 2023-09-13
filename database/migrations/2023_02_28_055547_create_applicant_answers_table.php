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
        Schema::create('applicant_answers', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->text('alasan')->nullable();
            $table->text('bidang')->nullable();
            $table->text('rencana')->nullable();
            $table->text('prestasi')->nullable();
            $table->text('lamaran')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_answers');
    }
};
