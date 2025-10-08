<?php

namespace App\Http\Controllers;

use App\Models\ParentAudio;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ParentAudioController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        \Log::info('ParentAudioController::store called');
        \Log::info('User authenticated: ' . (Auth::check() ? 'true' : 'false'));
        \Log::info('User ID: ' . Auth::id());
        \Log::info('Request data:', $request->all());
        \Log::info('Has audio_file: ' . ($request->hasFile('audio_file') ? 'true' : 'false'));
        
        \Log::info('Starting validation...');
        
        // Log specific validation details
        \Log::info('Word ID: ' . $request->word_id);
        \Log::info('Difficulty: ' . $request->difficulty);
        \Log::info('Duration seconds: ' . $request->duration_seconds);
        \Log::info('Audio file size: ' . ($request->hasFile('audio_file') ? $request->file('audio_file')->getSize() : 'No file'));
        \Log::info('Audio file MIME: ' . ($request->hasFile('audio_file') ? $request->file('audio_file')->getMimeType() : 'No file'));
        \Log::info('Audio file extension: ' . ($request->hasFile('audio_file') ? $request->file('audio_file')->getClientOriginalExtension() : 'No file'));
        
        // Only handle direct file uploads - no base64
        $request->validate([
            'word_id' => 'required|exists:words,id',
            'difficulty' => 'required|in:easy,normal,hard',
            'audio_file' => 'required|file|max:10240', // 10MB max - temporarily removed MIME validation
            'duration_seconds' => 'nullable|integer',
        ]);
        \Log::info('Validation passed');

        \Log::info('Getting parent ID and request data...');
        $parentId = Auth::id();
        $wordId = $request->word_id;
        $difficulty = $request->difficulty;
        \Log::info('Parent ID: ' . $parentId . ', Word ID: ' . $wordId . ', Difficulty: ' . $difficulty);

        // Check if audio already exists for this parent/word/difficulty
        \Log::info('Checking for existing audio...');
        $existingAudio = ParentAudio::where('parent_id', $parentId)
            ->where('word_id', $wordId)
            ->where('difficulty', $difficulty)
            ->first();
        \Log::info('Existing audio check complete');

        if ($existingAudio) {
            // Delete old audio file
            Storage::disk('public')->delete($existingAudio->audio_file_path);
            $existingAudio->delete();
        }

        // Store the audio file directly
        \Log::info('Processing audio file...');
        $audioFile = $request->file('audio_file');
        $fileName = Str::uuid() . '.' . $audioFile->getClientOriginalExtension();
        $filePath = 'parent-audio/' . $fileName;
        \Log::info('Generated filename: ' . $fileName);
        
        // Store the file using Laravel's file handling
        \Log::info('Storing file to disk...');
        $audioFile->storeAs('parent-audio', $fileName, 'public');
        \Log::info('File stored successfully');

        // Create new audio record
        \Log::info('Creating database record...');
        $parentAudio = ParentAudio::create([
            'parent_id' => $parentId,
            'word_id' => $wordId,
            'difficulty' => $difficulty,
            'audio_file_path' => $filePath,
            'audio_file_name' => $fileName,
            'duration_seconds' => $request->duration_seconds ?? null,
        ]);
        \Log::info('Database record created successfully');

        \Log::info('Returning success response...');
        return response()->json([
            'success' => true,
            'data' => $parentAudio,
            'message' => 'Audio uploaded successfully'
        ]);
    }

    public function getForChildren(Request $request, $wordId): JsonResponse
    {
        $difficulty = $request->query('difficulty', 'easy');
        
        // Get parent audio for this word and difficulty
        $parentAudio = ParentAudio::where('word_id', $wordId)
            ->where('difficulty', $difficulty)
            ->first();

        if ($parentAudio) {
            // Generate direct storage URL for local development
            // Use 10.0.2.2 for Android emulator to access host machine
            $baseUrl = 'http://10.0.2.2:8000';
            $audioUrl = $baseUrl . '/storage/parent-audio/' . $parentAudio->audio_file_name;
            
            // TODO: For production (Render), uncomment this and comment above:
            // $baseUrl = env('APP_URL', 'https://persian-learning-backend.onrender.com');
            // $audioUrl = $baseUrl . '/storage/parent-audio/' . $parentAudio->audio_file_name;
            
            return response()->json([
                'success' => true,
                'has_custom_audio' => true,
                'audio_url' => $audioUrl,
                'duration_seconds' => $parentAudio->duration_seconds,
            ]);
        }

        return response()->json([
            'success' => true,
            'has_custom_audio' => false,
            'audio_url' => null,
        ]);
    }

    public function index(): JsonResponse
    {
        $parentId = Auth::id();
        
        $parentAudios = ParentAudio::where('parent_id', $parentId)
            ->with('word')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $parentAudios
        ]);
    }

    public function show($id): JsonResponse
    {
        $parentAudio = ParentAudio::where('id', $id)
            ->where('parent_id', Auth::id())
            ->with('word')
            ->first();

        if (!$parentAudio) {
            return response()->json([
                'success' => false,
                'message' => 'Audio not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $parentAudio
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $parentAudio = ParentAudio::where('id', $id)
            ->where('parent_id', Auth::id())
            ->first();

        if (!$parentAudio) {
            return response()->json([
                'success' => false,
                'message' => 'Audio not found'
            ], 404);
        }

        // Delete the audio file
        Storage::disk('public')->delete($parentAudio->audio_file_path);
        
        // Delete the record
        $parentAudio->delete();

        return response()->json([
            'success' => true,
            'message' => 'Audio deleted successfully'
        ]);
    }


}
