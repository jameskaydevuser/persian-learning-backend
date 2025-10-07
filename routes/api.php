<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WordController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\ChildController;
use App\Http\Controllers\ParentSentenceController;
use App\Http\Controllers\ParentAudioController;
use App\Http\Controllers\AudioController;

// Authentication routes
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/child-login', [AuthenticatedSessionController::class, 'childLogin']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth:sanctum');

// Test route
Route::get('/test', function () {
    return response()->json(['message' => 'API is working!', 'status' => 'success']);
});

// Public routes (accessible without authentication)
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{key}', [CategoryController::class, 'show']);
Route::get('/words/{id}', [WordController::class, 'show']);

// Public sentence routes for children
Route::get('/sentences/{wordId}', [ParentSentenceController::class, 'getForChildren']);

// Audio routes (for default audio playback)
Route::get('/audio/word/{wordId}', [App\Http\Controllers\AudioController::class, 'getWordAudios']);

// Protected routes (require authentication)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Profile management
    Route::put('/user/profile', [App\Http\Controllers\ProfileController::class, 'updateProfile']);
    Route::put('/user/password', [App\Http\Controllers\ProfileController::class, 'changePassword']);
    
    // Progress (only authenticated users can track progress)
    Route::get('/user/progress', [ProgressController::class, 'getUserProgress']);
    Route::get('/user/progress/stats', [ProgressController::class, 'getProgressStats']);
    Route::get('/user/progress/{wordId}', [ProgressController::class, 'getWordProgress']);
    Route::post('/user/progress/{wordId}/mark-completed', [ProgressController::class, 'markProgress']);
    
    // Parent-only routes for managing children
    Route::get('/parent/children', [ChildController::class, 'index']);
    Route::post('/parent/children', [ChildController::class, 'store']);
    Route::get('/parent/children/{id}', [ChildController::class, 'show']);
    Route::put('/parent/children/{id}', [ChildController::class, 'update']);
    Route::delete('/parent/children/{id}', [ChildController::class, 'destroy']);
    Route::get('/parent/children-stats', [ChildController::class, 'getChildrenStats']);
    Route::get('/parent/children/{id}/progress', [ChildController::class, 'getChildProgress']);
    Route::get('/parent/children/{id}/progress-stats', [ChildController::class, 'getChildProgressStats']);
    
    // Parent profile management
    Route::get('/parent/profile', [App\Http\Controllers\ParentController::class, 'getProfile']);
    Route::put('/parent/profile', [App\Http\Controllers\ParentController::class, 'updateProfile']);
    Route::post('/parent/change-password', [App\Http\Controllers\ParentController::class, 'changePassword']);
    
    // Parent sentence management
    Route::get('/parent/sentences', [ParentSentenceController::class, 'index']);
    Route::get('/parent/sentences/{wordId}', [ParentSentenceController::class, 'show']);
    Route::post('/parent/sentences', [ParentSentenceController::class, 'store']);
    Route::put('/parent/sentences/{id}', [ParentSentenceController::class, 'update']);
    Route::delete('/parent/sentences/{id}', [ParentSentenceController::class, 'destroy']);
    
    // Parent audio management
    Route::get('/parent/audio', [ParentAudioController::class, 'index']);
    Route::get('/parent/audio/{id}', [ParentAudioController::class, 'show']);
    Route::post('/parent/audio', [ParentAudioController::class, 'store']);
    Route::delete('/parent/audio/{id}', [ParentAudioController::class, 'destroy']);
});

// Public routes for children to access parent audio
Route::get('/audio/parent/{wordId}', [ParentAudioController::class, 'getForChildren']);
Route::get('/audio/file/{filename}', [ParentAudioController::class, 'streamAudio']);

// Debug routes to check database
Route::get('/debug/tables', function() {
    $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table'");
    return response()->json([
        'tables' => $tables,
        'users_count' => App\Models\User::count(),
        'categories_count' => App\Models\Category::count(),
        'words_count' => App\Models\Word::count(),
        'parent_audio_count' => App\Models\ParentAudio::count(),
        'parent_sentences_count' => App\Models\ParentSentence::count(),
    ]);
});

Route::get('/debug/users', function() {
    return response()->json(App\Models\User::all());
});

Route::get('/debug/parent-audio', function() {
    return response()->json(App\Models\ParentAudio::with(['parent', 'word'])->get());
});

// Test audio route - simple file serving
Route::get('/test-audio', function() {
    $testFile = storage_path('app/public/parent-audio/31b919f4-b5eb-410f-9810-bac77eef5f69.mp3');
    
    if (!file_exists($testFile)) {
        return response()->json(['error' => 'File not found', 'path' => $testFile], 404);
    }
    
    return response()->file($testFile, [
        'Content-Type' => 'audio/mpeg',
        'Accept-Ranges' => 'bytes',
    ]);
});