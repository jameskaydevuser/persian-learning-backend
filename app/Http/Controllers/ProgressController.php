<?php

namespace App\Http\Controllers;

use App\Models\UserWordProgress;
use App\Models\Word;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function getUserProgress(): JsonResponse
    {
        $user = Auth::user();
        $progress = UserWordProgress::where('user_id', $user->id)
            ->with('word.category')
            ->get();

        return response()->json($progress);
    }

    public function getWordProgress(string $wordId): JsonResponse
    {
        $wordIdInt = (int) $wordId;
        $user = Auth::user();
        $progress = UserWordProgress::where('user_id', $user->id)
            ->where('word_id', $wordIdInt)
            ->with('word')
            ->first();

        if (!$progress) {
            return response()->json([
                'word_id' => $wordIdInt,
                'easy_completed' => false,
                'normal_completed' => false,
                'hard_completed' => false,
                'easy_completed_at' => null,
                'normal_completed_at' => null,
                'hard_completed_at' => null,
            ]);
        }

        return response()->json($progress);
    }

    public function markProgress(Request $request, string $wordId): JsonResponse
    {
        $request->validate([
            'difficulty' => 'required|in:easy,normal,hard'
        ]);

        $wordIdInt = (int) $wordId;
        $user = Auth::user();
        $difficulty = $request->difficulty;

        $progress = UserWordProgress::firstOrCreate([
            'user_id' => $user->id,
            'word_id' => $wordIdInt,
        ]);

        $completedField = $difficulty . '_completed';
        $completedAtField = $difficulty . '_completed_at';

        $progress->update([
            $completedField => true,
            $completedAtField => now(),
        ]);

        return response()->json([
            'message' => ucfirst($difficulty) . ' level completed successfully',
            'progress' => $progress->fresh()
        ]);
    }

    public function getProgressStats(): JsonResponse
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
            'total_words' => $totalWords,
            'completed_words' => $completedWords,
            'easy_completed' => $easyCompleted,
            'normal_completed' => $normalCompleted,
            'hard_completed' => $hardCompleted,
            'completion_percentage' => $totalWords > 0 ? round(($completedWords / $totalWords) * 100, 2) : 0
        ]);
    }
}
