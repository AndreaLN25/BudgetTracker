<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        return Category::all();
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:expense,income', 
        ]);

        $category = Category::create($request->all());

        return response()->json($category, 201);
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|in:expense,income',
        ]);

        $category->update($request->only(['name', 'type']));

        return response()->json($category);
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(null, 204);
    }
}
