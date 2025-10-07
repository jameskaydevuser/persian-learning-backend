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
        // Check if it's a base64 upload or file upload
        if ($request->has('audio_base64')) {
            $request->validate([
                'word_id' => 'required|exists:words,id',
                'difficulty' => 'required|in:easy,normal,hard',
                'audio_base64' => 'required|string',
                'duration_seconds' => 'nullable|integer',
            ]);

            $parentId = Auth::id();
            $wordId = $request->word_id;
            $difficulty = $request->difficulty;

            // Check if audio already exists for this parent/word/difficulty
            $existingAudio = ParentAudio::where('parent_id', $parentId)
                ->where('word_id', $wordId)
                ->where('difficulty', $difficulty)
                ->first();

            if ($existingAudio) {
                // Delete old audio file
                Storage::disk('public')->delete($existingAudio->audio_file_path);
                $existingAudio->delete();
            }

            // Decode base64 and store the audio file
            $base64Data = $request->audio_base64;
            
            // Remove data URL prefix if present
            if (strpos($base64Data, 'data:') === 0) {
                $base64Data = substr($base64Data, strpos($base64Data, ',') + 1);
            }
            
            $audioData = base64_decode($base64Data);
            
            \Log::info('Audio data info', [
                'base64_length' => strlen($request->audio_base64),
                'decoded_length' => strlen($audioData),
                'first_4_bytes' => bin2hex(substr($audioData, 0, 4)),
                'is_wav' => substr($audioData, 0, 4) === 'RIFF'
            ]);
            
            // Don't manipulate the audio data - store it as-is
            // The client should send properly formatted audio
            
            // Determine file extension based on actual format
            $extension = 'wav'; // Default
            if (substr($audioData, 0, 4) === 'RIFF') {
                $extension = 'wav';
            } elseif (substr($audioData, 0, 3) === 'ID3' || substr($audioData, 0, 2) === "\xFF\xFB") {
                $extension = 'mp3';
            }
            
            $fileName = Str::uuid() . '.' . $extension;
            $filePath = 'parent-audio/' . $fileName;
            
            Storage::disk('public')->put($filePath, $audioData);

            // Create new audio record
            $parentAudio = ParentAudio::create([
                'parent_id' => $parentId,
                'word_id' => $wordId,
                'difficulty' => $difficulty,
                'audio_file_path' => $filePath,
                'audio_file_name' => $fileName,
                'duration_seconds' => $request->duration_seconds ?? null,
            ]);

            return response()->json([
                'success' => true,
                'data' => $parentAudio,
                'message' => 'Audio uploaded successfully'
            ]);
        } else {
            // Original file upload logic
            $request->validate([
                'word_id' => 'required|exists:words,id',
                'difficulty' => 'required|in:easy,normal,hard',
                'audio_file' => 'required|file|mimes:mp3,wav,m4a|max:10240', // 10MB max
            ]);

            $parentId = Auth::id();
            $wordId = $request->word_id;
            $difficulty = $request->difficulty;

            // Check if audio already exists for this parent/word/difficulty
            $existingAudio = ParentAudio::where('parent_id', $parentId)
                ->where('word_id', $wordId)
                ->where('difficulty', $difficulty)
                ->first();

            if ($existingAudio) {
                // Delete old audio file
                Storage::disk('public')->delete($existingAudio->audio_file_path);
                $existingAudio->delete();
            }

            // Store the audio file
            $audioFile = $request->file('audio_file');
            $fileName = Str::uuid() . '.' . $audioFile->getClientOriginalExtension();
            $filePath = 'parent-audio/' . $fileName;
            
            Storage::disk('public')->put($filePath, file_get_contents($audioFile));

            // Create new audio record
            $parentAudio = ParentAudio::create([
                'parent_id' => $parentId,
                'word_id' => $wordId,
                'difficulty' => $difficulty,
                'audio_file_path' => $filePath,
                'audio_file_name' => $fileName,
                'duration_seconds' => $request->duration_seconds ?? null,
            ]);

            return response()->json([
                'success' => true,
                'data' => $parentAudio,
                'message' => 'Audio uploaded successfully'
            ]);
        }
    }

    public function getForChildren(Request $request, $wordId): JsonResponse
    {
        $difficulty = $request->query('difficulty', 'easy');
        
        // Get parent audio for this word and difficulty
        $parentAudio = ParentAudio::where('word_id', $wordId)
            ->where('difficulty', $difficulty)
            ->first();

        if ($parentAudio) {
            // Generate the API URL for the audio file
            $baseUrl = env('APP_URL', 'https://persian-learning-backend.onrender.com');
            $audioUrl = $baseUrl . '/api/audio/file/' . $parentAudio->audio_file_name;
            
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

    public function streamAudio($filename)
    {
        \Log::info('Stream audio request received', ['filename' => $filename]);
        
        $filePath = 'parent-audio/' . $filename;
        $fullPath = storage_path('app/public/' . $filePath);
        
        \Log::info('File path', ['fullPath' => $fullPath, 'exists' => file_exists($fullPath)]);
        
        if (!file_exists($fullPath)) {
            \Log::error('Audio file not found', ['fullPath' => $fullPath]);
            return response()->json([
                'success' => false,
                'message' => 'Audio file not found'
            ], 404);
        }
        
        // Determine content type based on file extension
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $contentType = match($extension) {
            'mp3' => 'audio/mpeg',
            'wav' => 'audio/wav',
            'm4a' => 'audio/mp4',
            'aac' => 'audio/aac',
            default => 'audio/mpeg'
        };
        
        \Log::info('Streaming audio file', ['contentType' => $contentType, 'extension' => $extension]);
        
        // Try using Storage facade to serve the file
        return response()->stream(function() use ($fullPath) {
            $file = fopen($fullPath, 'rb');
            fpassthru($file);
            fclose($file);
        }, 200, [
            'Content-Type' => $contentType,
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
