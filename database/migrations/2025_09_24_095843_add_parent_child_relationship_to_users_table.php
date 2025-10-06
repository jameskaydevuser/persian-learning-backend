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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['parent', 'child'])->default('child')->after('profile_image');
            $table->unsignedBigInteger('parent_id')->nullable()->after('role');
            $table->string('username')->nullable()->after('email'); // For child login
            $table->date('birth_date')->nullable()->after('username'); // For child profile
            $table->string('avatar_color', 7)->nullable()->after('birth_date'); // Hex color for child avatar
            
            // Add foreign key constraint
            $table->foreign('parent_id')->references('id')->on('users')->onDelete('cascade');
            
            // Add unique constraint for child username
            $table->unique('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['role', 'parent_id', 'username', 'birth_date', 'avatar_color']);
        });
    }
};
