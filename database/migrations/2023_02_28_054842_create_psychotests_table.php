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
        Schema::create('psychotests', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('disctest')->nullable();
            $table->string('ist')->nullable();
            $table->string('cfit')->nullable();
            $table->string('armyalpha')->nullable();
            $table->string('papikostik')->nullable();
            $table->string('kreplin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psychotests');
    }
};
