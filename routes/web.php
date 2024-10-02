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

Route::resource('users', UserController::class); // CRUD de usuarios

Route::middleware(['auth'])->group(function () {
    Route::resource('expenses', ExpenseController::class); // CRUD de gastos
    Route::resource('incomes', IncomeController::class); // CRUD de ingresos
    Route::resource('categories', CategoryController::class); // CRUD de categorías
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

});
