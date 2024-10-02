<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::with('category')->where('user_id', Auth::id())->get();
        return view('incomes.index', compact('incomes'));
    }

    public function create()
    {
        $categories = Category::where('type', 'income')->get();
        return view('incomes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => ['nullable', 'string', function ($attribute, $value, $fail) {
                    if ($value !== 'other' && !Category::where('id', $value)->exists()) {
                        $fail('The selected category is invalid.');
                    }
                }
            ],
            'new_category' => 'nullable|string|max:255|required_if:category_id,other',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        if ($request->category_id === 'other' && $request->new_category) {
            $category = Category::create([
                'name' => $request->new_category,
                'type' => 'income',
                'user_id' => Auth::id(),
            ]);

            $request->merge(['category_id' => $category->id]);
        }

        Income::create(array_merge($request->all(), ['user_id' => Auth::id()]));

        return redirect()->route('incomes.index')->with('success', 'Income created successfully.');
    }

    public function show(Income $income)
    {
        return view('incomes.show', compact('income'));
    }

    public function edit(Income $income)
    {
        if ($income->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::all();
        return view('incomes.edit', compact('income', 'categories'));
    }

    public function update(Request $request, Income $income)
    {
        if ($income->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $income->update($request->all());

        return redirect()->route('incomes.index')->with('success', 'Income updated successfully.');
    }

    public function destroy(Income $income)
    {
        if ($income->user_id !== Auth::id()) {
            abort(403);
        }

        $income->delete();
        return redirect()->route('incomes.index')->with('success', 'Income deleted successfully.');
    }
}
