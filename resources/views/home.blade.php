@extends('layouts.app')

@section('content')
<div class="jumbotron text-center">
    <h1>Welcome to the Budget Tracker</h1>
    <p>
        @if(Auth::check() && Auth::user()->isSuperAdmin())
            Manage users, incomes, and expenses with ease
        @else
            Manage your incomes and expenses easily
        @endif
    </p>
</div>

<div class="container">
    <div class="row mb-4">
        @if(Auth::check() && Auth::user()->isSuperAdmin())
            <div class="col-md-4 mb-4">
                <a href="{{ route('users.index') }}" class="card shadow-sm text-decoration-none border border-dark">
                    <div class="card-body text-dark text-center">
                        <h5 class="card-title">Manage Users</h5>
                        <p class="card-text">View and manage all users in the system</p>
                    </div>
                </a>
            </div>
        @endif

        @if(Auth::check()) <!-- Verifica si el usuario está logueado antes de mostrar los enlaces de ingresos y gastos -->
            <div class="col-md-4 mb-4">
                <a href="{{ route('incomes.index') }}" class="card shadow-sm text-decoration-none border border-dark">
                    <div class="card-body text-dark text-center">
                        <h5 class="card-title">View Incomes</h5>
                        <p class="card-text">Monitor all income records</p>
                    </div>
                </a>
            </div>

            <div class="col-md-4 mb-4">
                <a href="{{ route('expenses.index') }}" class="card shadow-sm text-decoration-none border border-dark">
                    <div class="card-body text-dark text-center">
                        <h5 class="card-title">View Expenses</h5>
                        <p class="card-text">Keep track of all expenses</p>
                    </div>
                </a>
            </div>
        @endif
    </div>

    <div class="row mb-4">
        @if(Auth::check() && Auth::user()->isSuperAdmin())
            <div class="col-md-4 mb-4">
                <a href="{{ route('categories.index') }}" class="card shadow-sm text-decoration-none border border-dark">
                    <div class="card-body text-dark text-center">
                        <h5 class="card-title">Manage Categories</h5>
                        <p class="card-text">Add, edit, or remove categories</p>
                    </div>
                </a>
            </div>

            <div class="col-md-4 mb-4">
                <a href="{{ route('admin.dashboard') }}" class="card shadow-sm text-decoration-none border border-dark">
                    <div class="card-body text-dark text-center">
                        <h5 class="card-title">Admin Dashboard</h5>
                        <p class="card-text">Access the admin dashboard for insights</p>
                    </div>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
