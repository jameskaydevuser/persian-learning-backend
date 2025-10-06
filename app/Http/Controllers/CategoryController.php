<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            // Get categories with word counts using a different approach
            $categories = Category::select('id', 'name', 'persian_name', 'description')->get();
            
            // Debug: Check if we have categories
            \Log::info("Found " . $categories->count() . " categories");
            
            // Manually count words for each category
            foreach ($categories as $category) {
                $wordCount = \App\Models\Word::where('category_id', $category->id)->count();
                $category->words_count = $wordCount;
                \Log::info("Category {$category->name} (ID: {$category->id}): {$wordCount} words");
            }
            
            return response()->json($categories);
        } catch (\Exception $e) {
            \Log::error("Error in CategoryController::index: " . $e->getMessage());
            return response()->json(['error' => 'Failed to load categories'], 500);
        }
    }

    public function show(string $key): JsonResponse
    {
        $category = Category::where('name', $key)->with('words')->first();
        
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json($category);
    }
}
