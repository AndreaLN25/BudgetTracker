<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Category::query();
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $categories = $query->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        if (Auth::check()) {
            return view('categories.create');
        } else {
            return redirect()->route('categories.index')->with('error', 'Unauthorized');
        }
    }

    public function store(Request $request)
    {
        if (Auth::check()) {
            $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'required|string|in:income,expense',
            ]);

            $data = $request->all();
            $data['user_id'] = Auth::id();

            Category::create($data);

            return redirect()->route('categories.index')->with('success', 'Category created successfully.');
        } else {
            return redirect()->route('categories.index')->with('error', 'Unauthorized');
        }
    }


    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:income,expense',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if ($category->user_id !== Auth::id() && !Auth::user()->isSuperAdmin()) {
            abort(403);
        }
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
