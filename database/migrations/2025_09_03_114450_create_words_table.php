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
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('english_word'); // English word (e.g., "Apple")
            $table->string('persian_word'); // Persian word (e.g., "سیب")
            $table->string('emoji'); // Emoji representation (e.g., "🍎")
            $table->string('audio_easy')->nullable(); // Audio file path for easy level
            $table->string('audio_normal')->nullable(); // Audio file path for normal level
            $table->string('audio_hard')->nullable(); // Audio file path for hard level
            $table->text('easy_text')->nullable(); // Easy level text (just the word)
            $table->text('normal_text')->nullable(); // Normal level text (simple sentence)
            $table->text('hard_text')->nullable(); // Hard level text (question)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('words');
    }
};
