<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::resource('users', UserController::class);

Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/home', [DashboardController::class, 'home'])->name('admin.home');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('expenses', ExpenseController::class);
    Route::resource('incomes', IncomeController::class);
    Route::resource('categories', CategoryController::class);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users/{id}/incomes', [DashboardController::class, 'showUserIncomes'])->name('users.incomes');
    Route::get('/users/{id}/expenses', [DashboardController::class, 'showUserExpenses'])->name('users.expenses');
    Route::get('/ratio', [DashboardController::class, 'showIncomeExpenseRatio'])->name('income_expense_ratio');
    Route::get('/incomes/category/{categoryId}', [DashboardController::class, 'showIncomesByCategory'])->name('incomes.byCategory');
    Route::get('/expenses/category/{categoryId}', [DashboardController::class, 'showExpensesByCategory'])->name('expenses.byCategory');
    Route::get('/income-expense-details/{categoryId}', [DashboardController::class, 'showIncomeExpenseDetailsByCategory'])->name('income-expense.details');
});
