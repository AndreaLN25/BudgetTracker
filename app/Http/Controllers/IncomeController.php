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
        return Income::all();
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

        return response()->json($income, 201);
    }

    /**
     * Display the specified income.
     */
    public function show(Income $income)
    {
        return $income;
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

        return response()->json($income);
    }

    /**
     * Remove the specified income from storage.
     */
    public function destroy(Income $income)
    {
        $income->delete();
        return response()->json(null, 204);
    }
}
