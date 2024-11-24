@extends('layouts.app')

@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<div class="jumbotron text-center {{ Auth::check() ? '' : 'mt-250' }}">
    @if(Auth::check())
        <h1>Welcome, {{ Auth::user()->name }}!</h1>
        <p>
            @if(Auth::user()->isSuperAdmin())
                Manage users, incomes, and expenses with ease.
            @else
                Manage your incomes and expenses easily.
            @endif
        </p>
    @else
        <h1>Welcome to the Budget Tracker</h1>
        <p>Please log in to start managing your finances.</p>
    @endif
</div>

<div class="container">
    <div class="row mb-4 d-flex justify-content-center">
        @if(Auth::check() && Auth::user()->isSuperAdmin())
            <div class="col-md-4 mb-4">
                <a href="{{ route('users.index') }}" class="card shadow-sm text-decoration-none border border-dark h-100">
                    <div class="card-body d-flex flex-column text-dark text-center">
                        <h5 class="card-title">Manage Users</h5>
                        <p class="card-text">View and manage all users in the system</p>
                    </div>
                </a>
            </div>
        @endif

        @if(Auth::check())
            <div class="col-md-4 mb-4">
                <a href="{{ route('incomes.index') }}" class="card shadow-sm text-decoration-none border border-dark h-100">
                    <div class="card-body d-flex flex-column text-dark text-center">
                        <h5 class="card-title">View Incomes</h5>
                        <p class="card-text">Keep track of all incomes</p>
                    </div>
                </a>
            </div>

            <div class="col-md-4 mb-4">
                <a href="{{ route('expenses.index') }}" class="card shadow-sm text-decoration-none border border-dark h-100">
                    <div class="card-body d-flex flex-column text-dark text-center">
                        <h5 class="card-title">View Expenses</h5>
                        <p class="card-text">Keep track of all expenses</p>
                    </div>
                </a>
            </div>
        @endif
    </div>

    <div class="row mb-4 d-flex justify-content-center">
        @if(Auth::check() && Auth::user()->isSuperAdmin())
            <div class="col-md-4 mb-4">
                <a href="{{ route('categories.index') }}" class="card shadow-sm text-decoration-none border border-dark h-100">
                    <div class="card-body d-flex flex-column text-dark text-center">
                        <h5 class="card-title">Manage Categories</h5>
                        <p class="card-text">Add, edit, or remove categories</p>
                    </div>
                </a>
            </div>

            <div class="col-md-4 mb-4">
                <a href="{{ route('admin.dashboard') }}" class="card shadow-sm text-decoration-none border border-dark h-100">
                    <div class="card-body d-flex flex-column text-dark text-center">
                        <h5 class="card-title">Admin Dashboard</h5>
                        <p class="card-text">Access the admin dashboard for insights</p>
                    </div>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
