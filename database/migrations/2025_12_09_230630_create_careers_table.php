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
        Schema::create('careers', function (Blueprint $table) {
            // $table->id();
            $table->id('career_id');
            $table->foreignId('player_id')->constrained('players', 'player_id')->cascadeOnDelete();
            $table->string('team');
            $table->string('season');
            $table->integer('matches');
            $table->integer('goals')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};
