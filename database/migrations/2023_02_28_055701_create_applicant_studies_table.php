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
        Schema::create('applicant_studies', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('tingkat');
            $table->string('sekolah');
            $table->string('kota')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('masuk')->nullable();
            $table->string('keluar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_studies');
    }
};
