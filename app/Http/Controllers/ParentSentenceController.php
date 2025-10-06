<?php

namespace App\Http\Controllers;

use App\Models\ParentSentence;
use App\Models\Word;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ParentSentenceController extends Controller
{
    /**
     * Get all sentences for a parent.
     */
    public function index(Request $request): JsonResponse
    {
        $parent = $request->user();
        
        if (!$parent->isParent()) {
            return response()->json(['message' => 'Access denied. Only parents can view sentences.'], 403);
        }

        $sentences = ParentSentence::where('parent_id', $parent->id)
            ->with('word')
            ->get();

        return response()->json($sentences);
    }

    /**
     * Get sentences for a specific word.
     */
    public function show(Request $request, $wordId): JsonResponse
    {
        $parent = $request->user();
        
        if (!$parent->isParent()) {
            return response()->json(['message' => 'Access denied. Only parents can view sentences.'], 403);
        }

        $sentences = ParentSentence::where('parent_id', $parent->id)
            ->where('word_id', $wordId)
            ->get();

        return response()->json($sentences);
    }

    /**
     * Create or update a sentence.
     */
    public function store(Request $request): JsonResponse
    {
        $parent = $request->user();
        
        if (!$parent->isParent()) {
            return response()->json(['message' => 'Access denied. Only parents can create sentences.'], 403);
        }

        $request->validate([
            'word_id' => 'required|integer|exists:words,id',
            'difficulty' => 'required|in:easy,normal,hard',
            'custom_sentence' => 'required|string|max:500',
        ]);

        try {
            // Check if sentence already exists for this word and difficulty
            $existingSentence = ParentSentence::where('parent_id', $parent->id)
                ->where('word_id', $request->word_id)
                ->where('difficulty', $request->difficulty)
                ->first();
            
            if ($existingSentence) {
                // Update existing sentence
                $existingSentence->update([
                    'custom_sentence' => $request->custom_sentence,
                ]);
                
                return response()->json([
                    'message' => 'Sentence updated successfully',
                    'sentence' => $existingSentence
                ]);
            } else {
                // Create new sentence
                $sentence = ParentSentence::create([
                    'parent_id' => $parent->id,
                    'word_id' => $request->word_id,
                    'difficulty' => $request->difficulty,
                    'custom_sentence' => $request->custom_sentence,
                ]);
                
                return response()->json([
                    'message' => 'Sentence created successfully',
                    'sentence' => $sentence
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Parent sentence save error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to save sentence'], 500);
        }
    }

    /**
     * Update a sentence.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $parent = $request->user();
        
        if (!$parent->isParent()) {
            return response()->json(['message' => 'Access denied. Only parents can update sentences.'], 403);
        }

        $request->validate([
            'custom_sentence' => 'required|string|max:500',
        ]);

        try {
            $sentence = ParentSentence::where('id', $id)
                ->where('parent_id', $parent->id)
                ->firstOrFail();
            
            $sentence->update([
                'custom_sentence' => $request->custom_sentence,
            ]);

            return response()->json([
                'message' => 'Sentence updated successfully',
                'sentence' => $sentence
            ]);
        } catch (\Exception $e) {
            \Log::error('Parent sentence update error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to update sentence'], 500);
        }
    }

    /**
     * Delete a sentence.
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $parent = $request->user();
        
        if (!$parent->isParent()) {
            return response()->json(['message' => 'Access denied. Only parents can delete sentences.'], 403);
        }

        try {
            $sentence = ParentSentence::where('id', $id)
                ->where('parent_id', $parent->id)
                ->firstOrFail();
            
            $sentence->delete();

            return response()->json([
                'message' => 'Sentence deleted successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Parent sentence delete error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to delete sentence'], 500);
        }
    }

    /**
     * Get sentences for children (public access).
     */
    public function getForChildren(Request $request, $wordId): JsonResponse
    {
        try {
            $sentences = ParentSentence::where('word_id', $wordId)
                ->select('difficulty', 'custom_sentence')
                ->get()
                ->keyBy('difficulty');
            
            return response()->json([
                'success' => true,
                'data' => [
                    'easy' => $sentences->get('easy')?->custom_sentence,
                    'normal' => $sentences->get('normal')?->custom_sentence,
                    'hard' => $sentences->get('hard')?->custom_sentence,
                    'has_custom_sentences' => $sentences->isNotEmpty(),
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Get sentences for children error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to get sentences'], 500);
        }
    }
}