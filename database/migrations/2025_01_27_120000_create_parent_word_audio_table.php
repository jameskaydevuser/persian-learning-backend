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
        Schema::create('parent_word_audio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id');
            $table->unsignedBigInteger('word_id');
            $table->enum('difficulty', ['easy', 'normal', 'hard']);
            $table->text('custom_sentence'); // Parent's custom sentence
            $table->string('audio_file_path')->nullable(); // Path to parent's audio recording
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('parent_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('word_id')->references('id')->on('words')->onDelete('cascade');
            
            // Unique constraint: one parent can have one custom audio per word per difficulty
            $table->unique(['parent_id', 'word_id', 'difficulty']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent_word_audio');
    }
};
