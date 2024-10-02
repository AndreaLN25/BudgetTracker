<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {
        $incomes = Income::where('user_id', Auth::id())->sum('amount');
        $expenses = Expense::where('user_id', Auth::id())->sum('amount');
        $balance = $incomes - $expenses;

        $incomeCategories = Income::with('category')
            ->where('user_id', Auth::id())
            ->select('category_id', DB::raw('SUM(amount) as total'))
            ->groupBy('category_id')
            ->get();

        $expenseCategories = Expense::with('category')
            ->where('user_id', Auth::id())
            ->select('category_id', DB::raw('SUM(amount) as total'))
            ->groupBy('category_id')
            ->get();

        $incomeData = $incomeCategories->pluck('total')->toArray();
        $incomeLabels = $incomeCategories->pluck('category.name')->toArray();

        $expenseData = $expenseCategories->pluck('total')->toArray();
        $expenseLabels = $expenseCategories->pluck('category.name')->toArray();

        return view('dashboard.index', compact('incomes', 'expenses', 'balance', 'incomeData', 'incomeLabels', 'expenseData', 'expenseLabels'));
    }
}
