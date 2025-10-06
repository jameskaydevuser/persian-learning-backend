<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ChildController extends Controller
{
    /**
     * Get all children of the authenticated parent.
     */
    public function index(Request $request)
    {
        $parent = $request->user();
        
        if (!$parent->isParent()) {
            return response()->json(['message' => 'Access denied. Only parents can view children.'], 403);
        }

        // Simplified response for debugging
        $children = $parent->children()->select('id', 'name', 'username', 'email', 'created_at')->get();

        // Add basic progress stats for each child
        $children->each(function ($child) {
            $child->progress_stats = [
                'total_words' => 0,
                'easy_completed' => 0,
                'normal_completed' => 0,
                'hard_completed' => 0,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $children
        ]);
    }

    /**
     * Get child's progress data for parent dashboard
     */
    public function getChildProgress(Request $request, $childId)
    {
        $parent = $request->user();
        
        if (!$parent->isParent()) {
            return response()->json(['message' => 'Access denied. Only parents can view child progress.'], 403);
        }

        // Verify the child belongs to this parent
        $child = $parent->children()->find($childId);
        if (!$child) {
            return response()->json(['message' => 'Child not found or access denied.'], 404);
        }

        $progress = \App\Models\UserWordProgress::where('user_id', $childId)
            ->with('word.category')
            ->get();

        return response()->json($progress);
    }

    /**
     * Get child's progress stats for parent dashboard
     */
    public function getChildProgressStats(Request $request, $childId)
    {
        $parent = $request->user();
        
        if (!$parent->isParent()) {
            return response()->json(['message' => 'Access denied. Only parents can view child progress.'], 403);
        }

        // Verify the child belongs to this parent
        $child = $parent->children()->find($childId);
        if (!$child) {
            return response()->json(['message' => 'Child not found or access denied.'], 404);
        }

        $totalWords = \App\Models\Word::count();
        $completedWords = \App\Models\UserWordProgress::where('user_id', $childId)
            ->where('easy_completed', true)
            ->where('normal_completed', true)
            ->where('hard_completed', true)
            ->count();

        $easyCompleted = \App\Models\UserWordProgress::where('user_id', $childId)
            ->where('easy_completed', true)
            ->count();

        $normalCompleted = \App\Models\UserWordProgress::where('user_id', $childId)
            ->where('normal_completed', true)
            ->count();

        $hardCompleted = \App\Models\UserWordProgress::where('user_id', $childId)
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

    /**
     * Create a new child for the authenticated parent.
     */
    public function store(Request $request)
    {
        $parent = $request->user();
        
        if (!$parent->isParent()) {
            return response()->json(['message' => 'Access denied. Only parents can create children.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6',
            'birth_date' => 'nullable|date|before:today',
            'avatar_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $child = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->username . '@child.local', // Dummy email for children
            'password' => Hash::make($request->password),
            'role' => 'child',
            'parent_id' => $parent->id,
            'birth_date' => $request->birth_date,
            'avatar_color' => $request->avatar_color ?? '#FF6B6B', // Default color
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Child created successfully',
            'data' => $child
        ], 201);
    }

    /**
     * Get a specific child of the authenticated parent.
     */
    public function show(Request $request, $id)
    {
        $parent = $request->user();
        
        if (!$parent->isParent()) {
            return response()->json(['message' => 'Access denied. Only parents can view children.'], 403);
        }

        $child = $parent->children()->find($id);
        
        if (!$child) {
            return response()->json([
                'success' => false,
                'message' => 'Child not found'
            ], 404);
        }

        // Load progress with word details
        $child->load(['wordProgress.word']);

        return response()->json([
            'success' => true,
            'data' => $child
        ]);
    }

    /**
     * Update a specific child of the authenticated parent.
     */
    public function update(Request $request, $id)
    {
        $parent = $request->user();
        
        if (!$parent->isParent()) {
            return response()->json(['message' => 'Access denied. Only parents can update children.'], 403);
        }

        $child = $parent->children()->find($id);
        
        if (!$child) {
            return response()->json([
                'success' => false,
                'message' => 'Child not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'username' => ['sometimes', 'string', 'max:255', Rule::unique('users', 'username')->ignore($child->id)],
            'password' => 'sometimes|string|min:6',
            'birth_date' => 'nullable|date|before:today',
            'avatar_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $updateData = $request->only(['name', 'username', 'birth_date', 'avatar_color']);
        
        if ($request->has('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $child->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Child updated successfully',
            'data' => $child->fresh()
        ]);
    }

    /**
     * Delete a specific child of the authenticated parent.
     */
    public function destroy(Request $request, $id)
    {
        $parent = $request->user();
        
        if (!$parent->isParent()) {
            return response()->json(['message' => 'Access denied. Only parents can delete children.'], 403);
        }

        $child = $parent->children()->find($id);
        
        if (!$child) {
            return response()->json([
                'success' => false,
                'message' => 'Child not found'
            ], 404);
        }

        $child->delete();

        return response()->json([
            'success' => true,
            'message' => 'Child deleted successfully'
        ]);
    }

    /**
     * Get progress statistics for all children of the authenticated parent.
     */
    public function getChildrenStats(Request $request)
    {
        $parent = $request->user();
        
        if (!$parent->isParent()) {
            return response()->json(['message' => 'Access denied. Only parents can view children stats.'], 403);
        }

        $children = $parent->children()->with('wordProgress')->get();
        
        $stats = [
            'total_children' => $children->count(),
            'children' => []
        ];

        foreach ($children as $child) {
            $progress = $child->wordProgress;
            $stats['children'][] = [
                'id' => $child->id,
                'name' => $child->name,
                'username' => $child->username,
                'avatar_color' => $child->avatar_color,
                'total_words' => $progress->count(),
                'easy_completed' => $progress->where('easy_completed', true)->count(),
                'normal_completed' => $progress->where('normal_completed', true)->count(),
                'hard_completed' => $progress->where('hard_completed', true)->count(),
                'completion_percentage' => $progress->count() > 0 ? 
                    round(($progress->where('easy_completed', true)->count() / $progress->count()) * 100, 2) : 0
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
}
