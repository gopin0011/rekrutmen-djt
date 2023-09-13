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
        Schema::create('applicant_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('nik')->nullable();
            $table->string('panggilan');
            $table->string('tempatlahir');
            $table->string('tanggallahir');
            $table->string('gender');
            $table->string('wn');
            $table->string('agama');
            $table->string('status');
            $table->string('darah')->nullable();
            $table->string('kontak')->nullable();
            $table->text('alamat')->nullable();
            $table->text('domisili')->nullable();
            $table->text('hobi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_profiles');
    }
};
