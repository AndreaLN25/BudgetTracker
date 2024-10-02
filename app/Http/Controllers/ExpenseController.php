<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::with('category')->where('user_id', Auth::id())->get();
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $categories = Category::where('type', 'expense')->get();
        return view('expenses.create', compact('categories'));
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
                'type' => 'expense',
                'user_id' => Auth::id(),
            ]);

            $request->merge(['category_id' => $category->id]);
        }

        Expense::create(array_merge($request->all(), ['user_id' => Auth::id()]));

        return redirect()->route('expenses.index')->with('success', 'Expense created successfully.');
    }

    public function show(Expense $expense)
    {
        return view('expense.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::all();
        return view('expenses.edit', compact('expense', 'categories'));
    }

    public function update(Request $request, Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $expense->update($request->all());

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->user_id !== Auth::id()) {
            abort(403);
        }

        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
