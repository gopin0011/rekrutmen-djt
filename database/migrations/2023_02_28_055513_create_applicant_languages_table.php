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
        Schema::create('applicant_languages', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('bahasa');
            $table->string('bicara');
            $table->string('baca');
            $table->string('tulis');
            $table->string('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_languages');
    }
};
