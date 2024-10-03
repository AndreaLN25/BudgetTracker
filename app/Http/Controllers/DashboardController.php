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

        if (Auth::user()->isSuperAdmin()) {
            $userCount = User::count();
            $totalIncomes = Income::sum('amount');
            $totalExpenses = Expense::sum('amount');
            $incomeCount = Income::count();
            $expenseCount = Expense::count();
            $categoryCount = Category::count();

            $incomeCategories = Income::with('category')
                ->select('category_id', DB::raw('SUM(amount) as total'))
                ->groupBy('category_id')
                ->get();

            $expenseCategories = Expense::with('category')
                ->select('category_id', DB::raw('SUM(amount) as total'))
                ->groupBy('category_id')
                ->get();

            $incomeCategoryLabels = $incomeCategories->pluck('category.name')->toArray();
            $incomeCategoryData = $incomeCategories->pluck('total')->toArray();

            $expenseCategoryLabels = $expenseCategories->pluck('category.name')->toArray();
            $expenseCategoryData = $expenseCategories->pluck('total')->toArray();

            $activeUsers = User::whereHas('incomes', function ($query) {
                $query->where('date', '>=', now()->subMonth());
            })->orWhereHas('expenses', function ($query) {
                $query->where('date', '>=', now()->subMonth());
            })->count();

            $users = User::with(['incomes', 'expenses'])->get();
            $userLabels = $users->pluck('name')->toArray();
            $userIds = $users->pluck('id')->toArray();
            $userDataBalances = $users->map(function ($user) {
                return $user->incomes->sum('amount') - $user->expenses->sum('amount');
            })->toArray();
            $userDataIncomes = $users->map(function ($user) {
                return $user->incomes->sum('amount');
            })->toArray();
            $userDataExpenses = $users->map(function ($user) {
                return $user->expenses->sum('amount');
            })->toArray();

            return view('admin.dashboard', compact(
                'incomes',
                'expenses',
                'balance',
                'incomeData',
                'incomeLabels',
                'expenseData',
                'expenseLabels',
                'incomeTrends',
                'expenseTrends',
                'months',
                'userCount',
                'totalIncomes',
                'totalExpenses',
                'incomeCount',
                'expenseCount',
                'categoryCount',
                'activeUsers',
                'incomeCategoryData',
                'incomeCategoryLabels',
                'expenseCategoryData',
                'expenseCategoryLabels',
                'userLabels',
                'userDataBalances',
                'userIds',
                'userDataIncomes',
                'userDataExpenses'
            ));
        }

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

    public function home()
    {
        return view('admin.home');
    }
}
