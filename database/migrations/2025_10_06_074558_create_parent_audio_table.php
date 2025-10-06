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
        Schema::create('parent_audio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('word_id')->constrained('words')->onDelete('cascade');
            $table->enum('difficulty', ['easy', 'normal', 'hard']);
            $table->string('audio_file_path');
            $table->string('audio_file_name');
            $table->integer('duration_seconds')->nullable();
            $table->timestamps();
            
            // Ensure one audio per parent per word per difficulty
            $table->unique(['parent_id', 'word_id', 'difficulty']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent_audio');
    }
};
