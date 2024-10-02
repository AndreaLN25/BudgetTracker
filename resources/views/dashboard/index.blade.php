<!-- resources/views/dashboard/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Dashboard</h1>

    <div class="row">
        <div class="col-md-4 mb-4">
            <a href="{{ route('incomes.index') }}" class="text-decoration-none">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Total Income</h5>
                        <p class="card-text h2">${{ number_format($incomes, 2) }}</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="{{ route('expenses.index') }}" class="text-decoration-none">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                        <h5 class="card-title">Total Expenses</h5>
                        <p class="card-text h2">${{ number_format($expenses, 2) }}</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-white {{ $balance >= 0 ? 'bg-info' : 'bg-warning' }}">
                <div class="card-body">
                    <h5 class="card-title">Balance</h5>
                    <p class="card-text h2">${{ number_format($balance, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <h3>Financial Summary</h3>
            <p>
                Your total income is <strong>${{ number_format($incomes, 2) }}</strong>, and your total expenses are <strong>${{ number_format($expenses, 2) }}</strong>.
            </p>
            <p>
                This gives you a balance of <strong>${{ number_format($balance, 2) }}</strong>.
                @if($balance >= 0)
                    Keep up the good work managing your finances!
                @else
                    You are in the negative; consider reviewing your expenses.
                @endif
            </p>
        </div>
    </div>


</div>
@endsection
