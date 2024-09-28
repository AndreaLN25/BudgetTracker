<?php

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Rutas para Expenses (Gastos)
Route::resource('expenses', ExpenseController::class);

// Rutas para Incomes (Ingresos)
Route::resource('incomes', IncomeController::class);

// Rutas para Categories (Categorías)
Route::resource('categories', CategoryController::class);
