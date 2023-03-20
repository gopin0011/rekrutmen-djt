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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('nik');
            $table->string('name');
            $table->string('corp');
            $table->string('dept');
            $table->string('position')->nullable();
            $table->string('gender');
            $table->string('religion');
            $table->string('kk')->nullable();
            $table->string('ktp')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('certi')->nullable();
            $table->string('place')->nullable();
            $table->string('born')->nullable();
            $table->string('bill')->nullable();
            $table->string('npwp')->nullable();
            $table->string('ptkp')->nullable();
            $table->string('status')->nullable();
            $table->string('joindate')->nullable();
            $table->string('study')->nullable();
            $table->string('school')->nullable();
            $table->string('prodi')->nullable();
            $table->string('ijazah')->nullable();
            $table->string('resign')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
