<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->isSuperAdmin()) {
            $query = Income::with('category','user');
        } else {
            $query = Income::with('category','user')->where('user_id', Auth::id());
        }

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->filled('min_amount')) {
            $query->where('amount', '>=', $request->min_amount);
        }

        if ($request->filled('max_amount')) {
            $query->where('amount', '<=', $request->max_amount);
        }

        $incomes = $query->get();
        $total = $incomes->sum('amount');

        $categories = Category::where('type', 'income')->get();

        return view('incomes.index', compact('incomes', 'total', 'categories'));
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

        $total = $request->amount;

        Income::create(array_merge($request->all(), ['user_id' => Auth::id(), 'total' => $total]));

        return redirect()->route('incomes.index')->with('success', 'Income created successfully.');
    }

    public function show(Income $income)
    {
        return view('incomes.show', compact('income'));
    }

    public function edit(Income $income)
    {
        if ($income->user_id !== Auth::id() && !Auth::user()->isSuperAdmin()) {
            abort(403);
        }

        $categories = Category::all();
        return view('incomes.edit', compact('income', 'categories'));
    }

    public function update(Request $request, Income $income)
    {
        if ($income->user_id !== Auth::id() && !Auth::user()->isSuperAdmin()) {
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
        if ($income->user_id !== Auth::id() && !Auth::user()->isSuperAdmin()) {
            abort(403);
        }

        $income->delete();
        return redirect()->route('incomes.index')->with('success', 'Income deleted successfully.');
    }
}
