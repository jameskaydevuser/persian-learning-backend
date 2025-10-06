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
            $audioData = base64_decode($request->audio_base64);
            
            // Ensure proper WAV header if it's missing
            // WAV files start with 'RIFF'
            if (substr($audioData, 0, 4) !== 'RIFF') {
                // If no WAV header, add a basic one
                // This is a simplified WAV header for mono, 16-bit, 44100Hz
                $sampleRate = 44100;
                $bitsPerSample = 16;
                $numChannels = 1;
                $dataSize = strlen($audioData);
                $byteRate = $sampleRate * $numChannels * ($bitsPerSample / 8);
                $blockAlign = $numChannels * ($bitsPerSample / 8);
                
                $header = pack('a4Va4', 'RIFF', 36 + $dataSize, 'WAVE');
                $header .= pack('a4V', 'fmt ', 16);
                $header .= pack('vvVVvv', 1, $numChannels, $sampleRate, $byteRate, $blockAlign, $bitsPerSample);
                $header .= pack('a4V', 'data', $dataSize);
                
                $audioData = $header . $audioData;
            }
            
            $fileName = Str::uuid() . '.wav';
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
            // For real device on different network, use ngrok URL
            $baseUrl = 'https://moody-faithlessly-aleigha.ngrok-free.dev';
            // For emulator, use: 'http://10.0.2.2:8000'
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
        
        \Log::info('Streaming audio file');
        
        return response()->file($fullPath, [
            'Content-Type' => 'audio/wav',
            'Accept-Ranges' => 'bytes',
        ]);
    }
}
