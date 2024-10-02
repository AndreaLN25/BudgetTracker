<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Models\Income;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $incomes = $this->getTotalIncomes($userId);
        $expenses = $this->getTotalExpenses($userId);
        $balance = $incomes - $expenses;

        $incomeCategories = $this->getIncomeCategories($userId);
        $expenseCategories = $this->getExpenseCategories($userId);

        $incomeData = $incomeCategories->pluck('total')->toArray();
        $incomeLabels = $incomeCategories->pluck('category.name')->toArray();
        $expenseData = $expenseCategories->pluck('total')->toArray();
        $expenseLabels = $expenseCategories->pluck('category.name')->toArray();

        $monthlyIncomes = $this->getMonthlyIncomes($userId);
        $monthlyExpenses = $this->getMonthlyExpenses($userId);

        $incomeTrends = $monthlyIncomes->pluck('total')->toArray();
        $expenseTrends = $monthlyExpenses->pluck('total')->toArray();
        $months = $monthlyIncomes->pluck('month')->toArray();

        return view('dashboard.index', compact(
            'incomes',
            'expenses',
            'balance',
            'incomeData',
            'incomeLabels',
            'expenseData',
            'expenseLabels',
            'incomeTrends',
            'expenseTrends',
            'months'
        ));
    }

    private function getTotalIncomes($userId)
    {
        return Income::where('user_id', $userId)->sum('amount');
    }

    private function getTotalExpenses($userId)
    {
        return Expense::where('user_id', $userId)->sum('amount');
    }

    private function getIncomeCategories($userId)
    {
        return Income::with('category')
            ->where('user_id', $userId)
            ->select('category_id', DB::raw('SUM(amount) as total'))
            ->groupBy('category_id')
            ->get();
    }

    private function getExpenseCategories($userId)
    {
        return Expense::with('category')
            ->where('user_id', $userId)
            ->select('category_id', DB::raw('SUM(amount) as total'))
            ->groupBy('category_id')
            ->get();
    }

    private function getMonthlyIncomes($userId)
    {
        return Income::where('user_id', $userId)
            ->select(DB::raw('MONTH(date) as month'), DB::raw('SUM(amount) as total'))
            ->where('date', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    private function getMonthlyExpenses($userId)
    {
        return Expense::where('user_id', $userId)
            ->select(DB::raw('MONTH(date) as month'), DB::raw('SUM(amount) as total'))
            ->where('date', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    public function adminIndex()
    {
        $userCount = User::count();
        $incomeCount = Income::count();
        $expenseCount = Expense::count();
        $categoryCount = Category::count();

        return view('admin.dashboard', compact('userCount', 'incomeCount', 'expenseCount','categoryCount'));
    }

    public function home()
    {
        return view('admin.home');
    }
}
