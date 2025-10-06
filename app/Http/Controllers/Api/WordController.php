<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WordController extends Controller
{
    /**
     * Display a listing of all words.
     */
    public function index(): JsonResponse
    {
        $words = Word::with('category')->get();
        
        return response()->json([
            'success' => true,
            'data' => $words
        ]);
    }

    /**
     * Display the specified word with its details.
     */
    public function show(string $id): JsonResponse
    {
        $word = Word::with('category')->find($id);
        
        if (!$word) {
            return response()->json([
                'success' => false,
                'message' => 'Word not found'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $word
        ]);
    }

    /**
     * Get words by category ID.
     */
    public function getWordsByCategory(string $categoryId): JsonResponse
    {
        $words = Word::where('category_id', $categoryId)->get();
        
        return response()->json([
            'success' => true,
            'data' => $words
        ]);
    }
}
