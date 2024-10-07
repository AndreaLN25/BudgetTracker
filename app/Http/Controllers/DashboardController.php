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

        $incomeCategories = $this->getCategoriesData(Income::class, $userId, 'income');
        $expenseCategories = $this->getCategoriesData(Expense::class, $userId, 'expense');

        $incomeData = $incomeCategories->pluck('total')->toArray();
        $incomeLabels = $incomeCategories->pluck('category.name')->toArray();
        $incomeCategoryIds = $incomeCategories->pluck('category_id')->toArray();

        $expenseData = $expenseCategories->pluck('total')->toArray();
        $expenseLabels = $expenseCategories->pluck('category.name')->toArray();
        $expenseCategoryIds = $expenseCategories->pluck('category_id')->toArray();

        $comparisonLabels = array_unique(array_merge(
            $incomeCategories->pluck('category.name')->toArray(),
            $expenseCategories->pluck('category.name')->toArray()
        ));

        $incomeData = [];
        $expenseData = [];

        foreach ($comparisonLabels as $label) {
            $incomeValue = $incomeCategories->where('category.name', $label)->first()->total ?? 0;
            $expenseValue = $expenseCategories->where('category.name', $label)->first()->total ?? 0;

            $incomeData[] = $incomeValue;
            $expenseData[] = $expenseValue;
        }

        // $monthlyIncomes = $this->getMonthlyData(Income::class, $userId);
        // $monthlyExpenses = $this->getMonthlyData(Expense::class, $userId);

        // $incomeTrends = $monthlyIncomes->pluck('total')->toArray();
        // $expenseTrends = $monthlyExpenses->pluck('total')->toArray();
        // $months = $monthlyIncomes->pluck('month')->toArray();

        if (Auth::user()->isSuperAdmin()) {
            $adminDashboardData = $this->getAdminDashboardData();
            return view('admin.dashboard', array_merge([
                'incomes', 'expenses', 'balance', 'incomeData', 'incomeLabels', 'incomeCategoryIds',
                'expenseData', 'expenseLabels', 'expenseCategoryIds',
                /* 'incomeTrends', 'expenseTrends', 'months', */ 'comparisonLabels'
            ], $adminDashboardData));
        }

        return view('dashboard.index', compact(
            'incomes', 'expenses', 'balance', 'incomeData', 'incomeLabels', 'incomeCategoryIds',
            'expenseData', 'expenseLabels', 'expenseCategoryIds',
            /* 'incomeTrends', 'expenseTrends', 'months', */ 'comparisonLabels'
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

    private function getCategoriesData($model, $userId = null, $type = null)
    {
        return $model::with('category')
            ->when($userId, fn($query) => $query->where('user_id', $userId))
            ->when($type, fn($query) => $query->whereHas('category', function ($q) use ($type) {
                $q->where('type', $type);
            }))
            ->select('category_id', DB::raw('SUM(amount) as total'))
            ->groupBy('category_id')
            ->get();
    }


    // private function getMonthlyData($model, $userId)
    // {
    //     return $model::where('user_id', $userId)
    //         ->select(DB::raw('DATE_FORMAT(date, "%Y-%m") as month'), DB::raw('SUM(amount) as total'))
    //         ->where('date', '>=', now()->subMonths(6))
    //         ->groupBy('month')
    //         ->orderBy('month')
    //         ->get();
    // }

    private function getAdminDashboardData()
    {
        $userCount = User::count();
        $totalIncomes = Income::sum('amount');
        $totalExpenses = Expense::sum('amount');
        $incomeCount = Income::count();
        $expenseCount = Expense::count();
        $categoryCount = Category::count();
        $activeUsers = User::whereHas('incomes', function ($query) {
            $query->where('date', '>=', now()->subMonth());
        })->orWhereHas('expenses', function ($query) {
            $query->where('date', '>=', now()->subMonth());
        })->count();

        $users = User::with(['incomes', 'expenses'])->get();
        $userLabels = $users->pluck('name')->toArray();
        $userIds = $users->pluck('id')->toArray();
        $userDataBalances = $users->map(fn($user) => $user->incomes->sum('amount') - $user->expenses->sum('amount'))->toArray();
        $userDataIncomes = $users->map(fn($user) => $user->incomes->sum('amount'))->toArray();
        $userDataExpenses = $users->map(fn($user) => $user->expenses->sum('amount'))->toArray();

        $incomeCategories = $this->getCategoriesData(Income::class, null, 'income');
        $expenseCategories = $this->getCategoriesData(Expense::class, null, 'expense');

        return [
            'userCount' => $userCount,
            'totalIncomes' => $totalIncomes,
            'totalExpenses' => $totalExpenses,
            'incomeCount' => $incomeCount,
            'expenseCount' => $expenseCount,
            'categoryCount' => $categoryCount,
            'activeUsers' => $activeUsers,
            'incomeCategoryData' => $incomeCategories->pluck('total')->toArray(),
            'incomeCategoryLabels' => $incomeCategories->pluck('category.name')->toArray(),
            'incomeCategoryIds' => $incomeCategories->pluck('category_id')->toArray(),
            'expenseCategoryData' => $expenseCategories->pluck('total')->toArray(),
            'expenseCategoryLabels' => $expenseCategories->pluck('category.name')->toArray(),
            'expenseCategoryIds' => $expenseCategories->pluck('category_id')->toArray(),
            'userLabels' => $userLabels,
            'userIds' => $userIds,
            'userDataBalances' => $userDataBalances,
            'userDataIncomes' => $userDataIncomes,
            'userDataExpenses' => $userDataExpenses
        ];
    }

    public function showUserIncomes($id)
    {
        $user = User::findOrFail($id);
        $categories = Category::all();
        request()->validate([
            'category' => 'nullable|exists:categories,id',
        ]);

        $incomes = $user->incomes()
            ->when(request('category'), function ($query) {
                $query->where('category_id', request('category'));
            })
            ->get();

        return view('users.incomes', compact('user', 'incomes', 'categories'));
    }

    public function showUserExpenses($id)
    {
        $user = User::findOrFail($id);
        $categories = Category::all();
        request()->validate([
            'category' => 'nullable|exists:categories,id',
        ]);

        $expenses = $user->expenses()
            ->when(request('category'), function ($query) {
                $query->where('category_id', request('category'));
            })
            ->get();

        return view('users.expenses', compact('user', 'expenses', 'categories'));
    }

    public function showIncomeExpenseRatio()
    {
        $incomeCategories = Category::where('type', 'income')->get();
        $expenseCategories = Category::where('type', 'expense')->get();

        $totalIncomes = Income::sum('amount');
        $totalExpenses = Expense::sum('amount');

        $incomesByCategory = [];
        $expensesByCategory = [];

        foreach ($incomeCategories as $category) {
            $incomesByCategory[$category->id] = Income::where('category_id', $category->id)
                ->with('user')
                ->get();
        }

        foreach ($expenseCategories as $category) {
            $expensesByCategory[$category->id] = Expense::where('category_id', $category->id)
                ->with('user')
                ->get();
        }

        return view('ratio.income_expense_ratio', compact('incomesByCategory', 'expensesByCategory', 'totalIncomes', 'totalExpenses'));
    }

    public function showIncomeExpenseDetailsByCategory($categoryId)
    {
        $incomes = $this->showIncomesByCategory($categoryId);

        $expenses = $this->showExpensesByCategory($categoryId);

        $details = [
            'incomes' => $incomes->getData()->incomes,
            'expenses' => $expenses->getData()->expenses,
        ];

        return view('income_expense_details', compact('details'));
    }

    public function showIncomesByCategory($categoryId)
    {
        $incomes = Income::where('category_id', $categoryId)->get();
        $category = Category::findOrFail($categoryId);
        return view('incomes.by_category', compact('incomes', 'category'));
    }

    public function showExpensesByCategory($categoryId)
    {
        $expenses = Expense::where('category_id', $categoryId)->get();
        $category = Category::findOrFail($categoryId);
        return view('expenses.by_category', compact('expenses', 'category'));
    }

    public function showUserIncomeExpenseDetails($userId)
    {
        $user = User::findOrFail($userId);
        $categories = Category::all();

        $incomes = $user->incomes;
        $expenses = $user->expenses; 

        return view('users.income_expense_details', compact('user', 'incomes', 'expenses', 'categories'));
    }



}
