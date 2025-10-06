<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Illuminate\Support\Facades\Storage;
use App\Models\Word;
use App\Models\Category;

// Bootstrap Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

/**
 * Script to migrate audio files from assets folder to database storage
 */
class AudioMigrationScript
{
    private $assetsPath;
    private $migratedCount = 0;
    private $errorCount = 0;
    private $errors = [];

    public function __construct()
    {
        // Path to the Speaking app assets folder
        $this->assetsPath = __DIR__ . '/../../Speaking/assets/audio';
    }

    public function run()
    {
        echo "🎵 Starting audio files migration...\n\n";
        
        if (!is_dir($this->assetsPath)) {
            echo "❌ Assets path not found: {$this->assetsPath}\n";
            return;
        }

        // Get all categories
        $categories = Category::all();
        
        foreach ($categories as $category) {
            $this->migrateCategoryAudio($category);
        }

        echo "\n📊 Migration Summary:\n";
        echo "✅ Successfully migrated: {$this->migratedCount} files\n";
        echo "❌ Errors: {$this->errorCount} files\n";
        
        if (!empty($this->errors)) {
            echo "\n🚨 Errors encountered:\n";
            foreach ($this->errors as $error) {
                echo "   - {$error}\n";
            }
        }
        
        echo "\n🎉 Migration completed!\n";
    }

    private function migrateCategoryAudio($category)
    {
        $categoryName = strtolower($category->name);
        $categoryPath = $this->assetsPath . '/' . $categoryName;
        
        echo "📁 Processing category: {$category->name} ({$categoryName})\n";
        
        if (!is_dir($categoryPath)) {
            echo "   ⚠️  Directory not found: {$categoryPath}\n";
            return;
        }

        // Get all words for this category
        $words = Word::where('category_id', $category->id)->get();
        
        foreach ($words as $word) {
            $this->migrateWordAudio($word, $categoryPath);
        }
    }

    private function migrateWordAudio($word, $categoryPath)
    {
        $wordName = $this->getWordFileName($word->english_word);
        echo "   🔤 Processing word: {$word->persian_word} ({$wordName})\n";
        
        $difficulties = ['easy', 'normal', 'hard'];
        
        foreach ($difficulties as $difficulty) {
            $fileName = "{$wordName}-{$difficulty}.mp3";
            $filePath = $categoryPath . '/' . $fileName;
            
            if (file_exists($filePath)) {
                $this->migrateAudioFile($word, $difficulty, $filePath);
            } else {
                echo "     ⚠️  File not found: {$fileName}\n";
            }
        }
    }

    private function migrateAudioFile($word, $difficulty, $filePath)
    {
        try {
            // Generate unique filename
            $filename = "word_{$word->id}_{$difficulty}_" . time() . '.mp3';
            
            // Copy file to storage
            $storagePath = "audio/{$filename}";
            Storage::disk('public')->put($storagePath, file_get_contents($filePath));
            
            // Update word record
            $audioField = "audio_{$difficulty}";
            $word->update([$audioField => $storagePath]);
            
            echo "     ✅ Migrated: {$difficulty} -> {$storagePath}\n";
            $this->migratedCount++;
            
        } catch (Exception $e) {
            $error = "Failed to migrate {$word->persian_word} ({$difficulty}): " . $e->getMessage();
            echo "     ❌ {$error}\n";
            $this->errors[] = $error;
            $this->errorCount++;
        }
    }

    private function getWordFileName($englishWord)
    {
        // Convert English word to lowercase and handle special cases
        $fileName = strtolower($englishWord);
        
        // Handle special cases
        $specialCases = [
            'orange' => 'orange', // Keep as is for colors
            'grape' => 'grapes', // Plural form in assets
        ];
        
        return $specialCases[$fileName] ?? $fileName;
    }
}

// Run the migration
$migration = new AudioMigrationScript();
$migration->run();
