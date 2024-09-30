<?php


use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});
require __DIR__.'/auth.php';

//Expenses
Route::resource('expenses', ExpenseController::class);

//Incomes
Route::resource('incomes', IncomeController::class);

//Categories
Route::resource('categories', CategoryController::class);

//Users
Route::resource('users', UserController::class);


