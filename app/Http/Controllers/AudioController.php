<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class AudioController extends Controller
{
    /**
     * Upload audio file for a specific word and difficulty level
     */
    public function uploadAudio(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'word_id' => 'required|integer|exists:words,id',
            'difficulty' => 'required|in:easy,normal,hard',
            'audio_file' => 'required|file|mimes:mp3,wav,m4a|max:10240', // Max 10MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $word = Word::findOrFail($request->word_id);
            $difficulty = $request->difficulty;
            
            // Generate unique filename
            $filename = "word_{$word->id}_{$difficulty}_" . time() . '.' . $request->file('audio_file')->getClientOriginalExtension();
            
            // Store the file
            $path = $request->file('audio_file')->storeAs('audio', $filename, 'public');
            
            // Update the word record with the audio file path
            $audioField = "audio_{$difficulty}";
            $word->update([$audioField => $path]);
            
            return response()->json([
                'success' => true,
                'message' => 'Audio uploaded successfully',
                'data' => [
                    'word_id' => $word->id,
                    'difficulty' => $difficulty,
                    'audio_path' => $path,
                    'audio_url' => Storage::url($path)
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload audio',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get audio file for a specific word and difficulty level
     */
    public function getAudio(Request $request, $wordId, string $difficulty)
    {
        $validator = Validator::make(['difficulty' => $difficulty], [
            'difficulty' => 'required|in:easy,normal,hard',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid difficulty level'
            ], 422);
        }

        try {
            $wordId = (int) $wordId;
            $word = Word::findOrFail($wordId);
            $audioField = "audio_{$difficulty}";
            $audioPath = $word->$audioField;
            
            if (!$audioPath || !Storage::disk('public')->exists($audioPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Audio file not found'
                ], 404);
            }
            
            $file = Storage::disk('public')->get($audioPath);
            $mimeType = Storage::disk('public')->mimeType($audioPath);
            
            return response($file, 200, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . basename($audioPath) . '"',
                'Cache-Control' => 'public, max-age=31536000', // Cache for 1 year
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve audio',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get audio URL for a specific word and difficulty level
     */
    public function getAudioUrl(Request $request, $wordId, string $difficulty)
    {
        $validator = Validator::make(['difficulty' => $difficulty], [
            'difficulty' => 'required|in:easy,normal,hard',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid difficulty level'
            ], 422);
        }

        try {
            $wordId = (int) $wordId;
            $word = Word::findOrFail($wordId);
            $audioField = "audio_{$difficulty}";
            $audioPath = $word->$audioField;
            
            if (!$audioPath || !Storage::disk('public')->exists($audioPath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Audio file not found'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'word_id' => $wordId,
                    'difficulty' => $difficulty,
                    'audio_url' => request()->getSchemeAndHttpHost() . Storage::url($audioPath)
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get audio URL',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete audio file for a specific word and difficulty level
     */
    public function deleteAudio(Request $request, $wordId, string $difficulty)
    {
        $validator = Validator::make(['difficulty' => $difficulty], [
            'difficulty' => 'required|in:easy,normal,hard',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid difficulty level'
            ], 422);
        }

        try {
            $wordId = (int) $wordId;
            $word = Word::findOrFail($wordId);
            $audioField = "audio_{$difficulty}";
            $audioPath = $word->$audioField;
            
            if ($audioPath && Storage::disk('public')->exists($audioPath)) {
                Storage::disk('public')->delete($audioPath);
            }
            
            // Clear the audio path in the database
            $word->update([$audioField => null]);
            
            return response()->json([
                'success' => true,
                'message' => 'Audio deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete audio',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all audio files for a specific word
     */
    public function getWordAudios(Request $request, $wordId)
    {
        try {
            $wordId = (int) $wordId;
            $word = Word::findOrFail($wordId);
            
            $audios = [];
            foreach (['easy', 'normal', 'hard'] as $difficulty) {
                $audioField = "audio_{$difficulty}";
                $audioPath = $word->$audioField;
                
                $audios[$difficulty] = [
                    'has_audio' => !empty($audioPath) && Storage::disk('public')->exists($audioPath),
                    'audio_url' => $audioPath ? request()->getSchemeAndHttpHost() . Storage::url($audioPath) : null,
                    'audio_path' => $audioPath
                ];
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'word_id' => $wordId,
                    'word' => $word->persian_word,
                    'audios' => $audios
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get word audios',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}