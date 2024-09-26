<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the expenses.
     */
    public function index()
    {
        return Expense::all();
    }

    /**
     * Store a newly created expense in storage.
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

        $expense = Expense::create($request->all());

        return response()->json($expense, 201);
    }

    /**
     * Display the specified expense.
     */
    public function show(Expense $expense)
    {
        return $expense;
    }

    /**
     * Update the specified expense in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'amount' => 'sometimes|numeric',
            'description' => 'sometimes|string',
            'date' => 'sometimes|date',
        ]);

        $expense->update($request->only(['category_id', 'amount', 'description', 'date']));

        return response()->json($expense);
    }

    /**
     * Remove the specified expense from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return response()->json(null, 204);
    }
}
