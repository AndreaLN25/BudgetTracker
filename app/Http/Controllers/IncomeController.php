<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    /**
     * Display a listing of the incomes.
     */
    public function index()
    {
        $incomes = Income::all();

        return view('incomes.index', compact('incomes'));
    }

    /**
     * Show the form for creating a new income.
     */
    public function create()
    {
        return view('incomes.create');
    }

    /**
     * Store a newly created income in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $income = Income::create($request->all());

        return redirect()->route('incomes.index')->with('success', 'Income created successfully.');
    }

    /**
     * Display the specified income.
     */
    public function show(Income $income)
    {
        return view('incomes.show', compact('income'));
    }

    /**
     * Show the form for editing the specified income.
     */
    public function edit(Income $income)
    {
        return view('incomes.edit', compact('income'));
    }

    /**
     * Update the specified income in storage.
     */
    public function update(Request $request, Income $income)
    {
        $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'amount' => 'sometimes|numeric',
            'description' => 'sometimes|string',
            'date' => 'sometimes|date',
        ]);

        $income->update($request->only(['category_id', 'amount', 'description', 'date']));

        return redirect()->route('incomes.index')->with('success', 'Income updated successfully.');
    }

    /**
     * Remove the specified income from storage.
     */
    public function destroy(Income $income)
    {
        $income->delete();

        return redirect()->route('incomes.index')->with('success', 'Income deleted successfully.');
    }
}
