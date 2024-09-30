<?php

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Ruta principal
Route::get('/', function () {
    return view('home'); // Vista principal
});

// Rutas de autenticación
require __DIR__.'/auth.php'; // Incluye las rutas de autenticación generadas por Breeze

// Rutas públicas y protegidas por autenticación (no requieren 'auth:sanctum')
Route::resource('expenses', ExpenseController::class); // CRUD de gastos
Route::resource('incomes', IncomeController::class); // CRUD de ingresos
Route::resource('categories', CategoryController::class); // CRUD de categorías

// Rutas de usuarios (pueden ser públicas o protegidas según tu necesidad)
Route::resource('users', UserController::class); // CRUD de usuarios
