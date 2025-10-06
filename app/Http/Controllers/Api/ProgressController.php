<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserWordProgress;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    /**
     * Get user's progress for all words.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $progress = UserWordProgress::where('user_id', $user->id)
            ->with('word.category')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $progress
        ]);
    }

    /**
     * Get user's progress for a specific word.
     */
    public function show(string $wordId): JsonResponse
    {
        $user = Auth::user();
        $progress = UserWordProgress::where('user_id', $user->id)
            ->where('word_id', $wordId)
            ->with('word')
            ->first();
        
        if (!$progress) {
            // Create new progress record if it doesn't exist
            $progress = UserWordProgress::create([
                'user_id' => $user->id,
                'word_id' => $wordId,
                'easy_completed' => false,
                'normal_completed' => false,
                'hard_completed' => false
            ]);
        }
        
        return response()->json([
            'success' => true,
            'data' => $progress
        ]);
    }

    /**
     * Mark a difficulty level as completed for a word.
     */
    public function markCompleted(Request $request, string $wordId): JsonResponse
    {
        $request->validate([
            'difficulty' => 'required|in:easy,normal,hard'
        ]);

        $user = Auth::user();
        $difficulty = $request->difficulty;
        
        $progress = UserWordProgress::firstOrCreate([
            'user_id' => $user->id,
            'word_id' => $wordId
        ]);
        
        // Mark the difficulty as completed
        $progress->update([
            $difficulty . '_completed' => true,
            $difficulty . '_completed_at' => now()
        ]);
        
        return response()->json([
            'success' => true,
            'message' => ucfirst($difficulty) . ' level completed',
            'data' => $progress
        ]);
    }

    /**
     * Get user's overall progress statistics.
     */
    public function getStats(): JsonResponse
    {
        $user = Auth::user();
        
        $totalWords = Word::count();
        $completedWords = UserWordProgress::where('user_id', $user->id)
            ->where('easy_completed', true)
            ->where('normal_completed', true)
            ->where('hard_completed', true)
            ->count();
        
        $easyCompleted = UserWordProgress::where('user_id', $user->id)
            ->where('easy_completed', true)
            ->count();
        
        $normalCompleted = UserWordProgress::where('user_id', $user->id)
            ->where('normal_completed', true)
            ->count();
        
        $hardCompleted = UserWordProgress::where('user_id', $user->id)
            ->where('hard_completed', true)
            ->count();
        
        return response()->json([
            'success' => true,
            'data' => [
                'total_words' => $totalWords,
                'completed_words' => $completedWords,
                'easy_completed' => $easyCompleted,
                'normal_completed' => $normalCompleted,
                'hard_completed' => $hardCompleted
            ]
        ]);
    }
}
