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
        Schema::create('user_word_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('word_id')->constrained()->onDelete('cascade');
            $table->boolean('easy_completed')->default(false); // Easy level completed
            $table->boolean('normal_completed')->default(false); // Normal level completed
            $table->boolean('hard_completed')->default(false); // Hard level completed
            $table->timestamp('easy_completed_at')->nullable(); // When easy level was completed
            $table->timestamp('normal_completed_at')->nullable(); // When normal level was completed
            $table->timestamp('hard_completed_at')->nullable(); // When hard level was completed
            $table->timestamps();
            
            // Ensure unique combination of user and word
            $table->unique(['user_id', 'word_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_word_progress');
    }
};
