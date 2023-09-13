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
        Schema::create('applicant_careers', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('perusahaan');
            $table->string('alamat')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('masuk')->nullable();
            $table->string('keluar')->nullable();
            $table->string('gaji')->nullable();
            $table->text('pekerjaan')->nullable();
            $table->text('prestasi')->nullable();
            $table->text('alasan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_careers');
    }
};
