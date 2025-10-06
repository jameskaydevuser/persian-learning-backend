<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Category;
use App\Models\Word;
use App\Models\ParentAudio;
use App\Models\ParentSentence;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/dashboard', function () {
    try {
        $users = User::all();
        $categories = Category::with('words')->get();
        $words = Word::with('category')->limit(10)->get();
        $parent_audios = ParentAudio::with(['parent', 'word'])->get();
        $parent_sentences = ParentSentence::with(['parent', 'word'])->get();
        
        $stats = [
            'users' => User::count(),
            'categories' => Category::count(),
            'words' => Word::count(),
            'parent_audio' => ParentAudio::count(),
            'parent_sentences' => ParentSentence::count(),
        ];
        
        return view('dashboard', compact('users', 'categories', 'words', 'parent_audios', 'parent_sentences', 'stats'));
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile()
        ], 500);
    }
});

require __DIR__.'/auth.php';
