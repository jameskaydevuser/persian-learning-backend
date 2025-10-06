<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\JsonResponse;

class WordController extends Controller
{
    public function show(string $id): JsonResponse
    {
        $wordId = (int) $id;
        $word = Word::with(['category', 'parent_sentences'])->find($wordId);
        
        if (!$word) {
            return response()->json(['message' => 'Word not found'], 404);
        }

        return response()->json($word);
    }
}
